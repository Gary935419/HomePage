<?php

namespace App\Http\Controllers;

class LogoutController extends Controller
{
    public function postLogout()
    {
        $this->Admin->logout();
        return view('login/index');
    }
}
