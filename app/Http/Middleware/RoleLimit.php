<?php

namespace App\Http\Middleware;

use App\Role;
use App\User;
use Closure;
use Illuminate\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class RoleLimit
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $role
     * @return mixed
     */
    //角色繼承關係
    //FIXME 不該有角色繼承，應使用權限作為基本控管
    static protected $inheritance = [
        'admin' => ['staff'],
        'staff' => []
    ];

    public function handle($request, Closure $next, $role)
    {

        if ($this->auth->guest()) {
            //未登入
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->route('user.login');
            }
        } elseif (!$this->checkRoleInheritance(Auth::user(), $role)) {
            //權限不足
            return redirect()->route('home')
                ->with('warning', '權限不足');
        } elseif (empty($this->auth->user()->confirm_at)) {
            //未驗證信箱
            return redirect()->route('user.resend')
                ->with('warning', '完成信箱驗證方可進入此頁面');
        }
        return $next($request);
    }

    //FIXME 不該有角色繼承，應使用權限作為基本控管
    protected function checkRoleInheritance(User $user = null, $roleName)
    {
        //未登入直接不通過
        if (!$user) {
            return false;
        }
        //直接擁有該角色
        if ($user->hasRole($roleName)) {
            return true;
        }
        //檢查角色是否存在
        $role = Role::where('name', $roleName)->first();
        if (!$role) {
            return false;
        }
        //檢查擁有的角色，是否繼承欲檢查之角色
        $roleList = $user->roles;
        foreach ($roleList as $roleItem) {
            if (isset(static::$inheritance[$roleItem->name])
                || array_key_exists($roleItem->name, static::$inheritance)
            ) {
                //繼承表有該角色
                $roleInheritanceList = static::$inheritance[$roleItem->name];
                if (is_array($roleInheritanceList)) {
                    foreach ($roleInheritanceList as $roleInheritance) {
                        if ($roleInheritance = $role->name) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
}