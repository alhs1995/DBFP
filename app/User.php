<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract,  CanResetPasswordContract
{
    use Authenticatable,  CanResetPassword, EntrustUserTrait;

    protected $table = 'users';
    protected $fillable = [
        'username',
        'password',
        'nickname',
        'email',
        'address',
        'debug',
        'confirm_code',
        'confirm_at',
        'register_ip',
        'register_at',
        'lastlogin_ip',
        'lastlogin_at'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function isConfirmed()
    {
        if (!empty($this->confirm_at)) {
            return true;
        }
        return false;
    }

    public function getNickname()
    {
        if (!empty($this->nickname)) {
            $nickname = $this->nickname;
        } else {
            $nickname = explode("@", $this->email)[0];
        }
        return $nickname;
    }

    public function getInDebugModeAttribute()
    {
        //限管理員
        if (!\Entrust::hasRole('admin')) {
            return false;
        }
        if (!$this->debug) {
            return false;
        }
        return true;
    }
}
