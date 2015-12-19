<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Auth System
Route::controller('user', 'UserController', [
    'getIndex' => 'user.list',
    'getLogin' => 'user.login',
    'postLogin' => 'user.login',
    'getRegister' => 'user.register',
    'postRegister' => 'user.register',
    'getConfirm' => 'user.confirm',
    'getResend' => 'user.resend',
    'postResend' => 'user.resend',
    'getForgotPassword' => 'user.forgot-password',
    'postForgotPassword' => 'user.forgot-password',
    'getResetPassword' => 'user.reset-password',
    'postResetPassword' => 'user.reset-password',
    'getChangePassword' => 'user.change-password',
    'postChangePassword' => 'user.change-password',
    'getProfile' => 'user.profile',
    'getEditProfile' => 'user.edit-profile',
    'postEditProfile' => 'user.edit-profile',
    'getEditOtherProfile' => 'user.edit-other-profile',
    'postEditOtherProfile' => 'user.edit-other-profile',
    'getLogout' => 'user.logout'
]);


//未定義路由
Route::get('{all}', [
    'as' => 'not-found',
    function () {
        abort(404);
    }
])->where('all', '.*');