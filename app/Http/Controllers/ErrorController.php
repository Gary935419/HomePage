<?php

namespace App\Http\Controllers;

/**
 * IPアドレスを許可する
 */
class ErrorController extends Controller
{
    public function ipError()
    {
        return view('error/ip_error');
    }
}
