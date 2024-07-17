<?php

namespace App\Http\Controllers;
use App\Models\Admins;

class MainController extends Controller
{
    /**
     * ログイン画面
     */
    public function index()
    {
        return view('main/index', $this->data);
    }
}
