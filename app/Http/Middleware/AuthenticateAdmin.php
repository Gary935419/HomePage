<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\AuthGroupOtbSimpleGroup;
use Closure;
use Illuminate\Http\Request;

class AuthenticateAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $Admin = new Admin($this);
        // ログイン画面以外は、未ログインの場合、ログイン画面へ
        if (!$Admin->authCheck() && $request->path() != 'login' && $request->post('FORCED_CHANGE_PASSWORD_USER_ID') == null) {
            return redirect('/login');
        }

        // ログイン後で且つ、権限が無い場合は、ログインページヘ（そもそも表示されない）
        elseif ($request->path() != 'login' && $request->path() != 'logout' && $request->path() != 'admin' && $request->post('FORCED_CHANGE_PASSWORD_USER_ID') == null && !AuthGroupOtbSimpleGroup::has_access(strtolower($request->segment(1).".".$request->segment(2)))) {
            return redirect('/login');
        }
        return $next($request);
    }
}
