<?php

namespace App\Http\Controllers;

class LoginController extends Controller
{
    /**
     * ログイン画面
     */
    public function index()
    {
        return view('login/index');
    }
    /**
     * ログイン実行
     */
    public function postLogin()
    {
        $params = request()->all();
        if ($this->Admin->validateUser($params['USER_ID'], $params['USER_PASSWORD'])) {
            $password_expired_time = $this->Admin->getPasswordExpiredTime([config('auth.username_post_key', 'USER_ID') => $params['USER_ID']]);
            $password_expired_time = strtotime($password_expired_time);
            $current_time = time();
            // ログイン実行
            $this->Admin->login($params['USER_ID'], $params['USER_PASSWORD']);
            //パスワード期間切れ処理
            if ($password_expired_time != null && $current_time >= $password_expired_time) {
                return view('userinfo/password_change_forced', ['USER_ID' => $params['USER_ID']]);
            }
            return redirect('/admin');
        }
        // ログイン失敗
        return view('login/index', ['ERROR' => 'アカウント番号またはパスワードが間違っています。']);
    }
}
