<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    echo "Project:admin.donghai";
});

//Adminユーザー登録に関連するルーティングの配置です。
Route::middleware(['auth.admin','req.trim'])->group(function () {
    // Adminホーム画面
    Route::get('/', 'MainController@index');
    // Login画面
    Route::get('/login', 'LoginController@index')->name('login');
    // Login画面Api
    Route::post('/login', 'LoginController@postLogin');
    // Logout画面Api
    Route::post('/logout', 'LogoutController@postLogout')->name('logout');
    // IP制限エラー
    Route::get('/error/ip_error', 'ErrorController@ipError');
});
//Apiに関連するルーティングの配置です。
Route::middleware(['req.trim'])->group(function () {
    Route::group(['prefix' => 'api'], function ($app) {
        //权限设定
        $app->post('admins/user_rights_setting', 'api\AdminsController@action_user_rights_setting');
        //上传图片
        $app->post('upload/pushFIle', 'api\AdminsController@actionUploadImg');
    });
});
//Bladeに関連するルーティングの配置です。
Route::middleware(['auth.admin','req.trim'])->group(function () {
    Route::group(['prefix' => 'userinfo'], function ($set) {
        // パスワード変更
        $set->get('password_change', 'UserInfoController@get_password_change');
        $set->post('password_change', 'UserInfoController@post_password_change');
        // 管理画面ユーザー情報
        // 設定適用
        $set->get('admin_user_info', 'UserInfoController@get_admin_user_info');
        $set->post('admin_user_info', 'UserInfoController@post_admin_user_info');
        // 削除
        $set->get('admin_remove_user', 'UserInfoController@action_admin_remove_user');
        // ユーザー追加
        $set->get('admin_add_user', 'UserInfoController@get_admin_add_user');
        $set->post('admin_add_user', 'UserInfoController@post_admin_add_user');
        // パスワードリセット
        $set->get('force_password_change', 'UserInfoController@get_force_password_change');
        $set->post('force_password_change', 'UserInfoController@post_force_password_change');
        // アクセス詳細設定
        $set->get('admin_user_rights_setting', 'UserInfoController@get_admin_user_rights_setting');
        $set->post('admin_user_rights_setting', 'UserInfoController@post_admin_user_rights_setting');
    });
});

