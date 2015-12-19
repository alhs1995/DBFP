<?php

namespace App\Http\Middleware;

use App\Permission;
use Closure;
use Illuminate\Auth\Guard;

class PermissionCheck
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
    public function handle($request, Closure $next, $permissionName)
    {

        if ($this->auth->guest()) {
            //未登入
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->route('member.login');
            }
        }
        $user = $this->auth->user();
        if (empty($user->confirm_at)) {
            //未驗證信箱
            return redirect()->route('member.resend')
                ->with('warning', '完成信箱驗證方可進入此頁面');
        }
        //取得權限
        $permission = Permission::where('name', '=', $permissionName)->first();
        if (!$permission || !$user->can($permissionName)) {
            return redirect()->route('home')
                ->with('warning', '權限不足');
        }
        return $next($request);
    }

}