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
    echo "Project:FRONT.HOME.PAGE";
});

//Adminユーザー登録に関連するルーティングの配置です。
Route::middleware(['auth.admin','req.trim'])->group(function () {
    // Adminホーム画面
    Route::get('/admin', 'MainController@index');
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
        $app->post('admins/user_rights_setting', 'api\AdminsController@action_user_rights_setting');
        $app->post('upload/pushFIle', 'api\AdminsController@actionUploadImg');
        $app->post('goods/goods_delete', 'api\GoodsController@post_goods_delete');
        $app->post('goods/goods_labledelete', 'api\GoodsController@post_goods_labledelete');
        $app->post('goods/goods_bannerdelete', 'api\GoodsController@post_goods_bannerdelete');
        $app->post('imports/recedents_delete', 'api\ImportsController@post_recedents_delete');
        $app->post('imports/company_delete', 'api\ImportsController@post_company_delete');
        $app->post('imports/lable_delete', 'api\ImportsController@post_lable_delete');
        $app->post('news/news_delete', 'api\NewsController@post_news_delete');
        $app->post('seminar/exhibition_delete', 'api\SeminarController@post_exhibition_delete');
        $app->post('seminar/teacher_delete', 'api\SeminarController@post_teacher_delete');
        $app->post('seminar/lable_delete', 'api\SeminarController@post_lable_delete');
        $app->post('management/site_delete', 'api\ManagementController@post_site_delete');
        $app->post('download/file_delete', 'api\DownloadController@post_file_delete');
        $app->post('download/category_delete', 'api\DownloadController@post_category_delete');
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

    //製品情報
    Route::group(['prefix' => 'goods'], function ($set) {
        $set->get('goods_add', 'GoodsController@get_goods_add');
        $set->post('goods_regist', 'GoodsController@post_goods_regist');
        $set->get('goods_lists/{recovery?}', 'GoodsController@get_goods_lists');
        $set->get('goods_edit/{id}', 'GoodsController@get_goods_edit');
        $set->post('goods_edit', 'GoodsController@post_goods_edit');

        $set->get('goods_lableadd', 'GoodsController@get_goods_lableadd');
        $set->post('goods_lableregist', 'GoodsController@post_goods_lableregist');
        $set->get('goods_lablelists/{recovery?}', 'GoodsController@get_goods_lablelists');
        $set->get('goods_lableedit/{id}', 'GoodsController@get_goods_lableedit');
        $set->post('goods_lableedit', 'GoodsController@post_goods_lableedit');

        $set->get('goods_banneradd', 'GoodsController@get_goods_banneradd');
        $set->post('goods_bannerregist', 'GoodsController@post_goods_bannerregist');
        $set->get('goods_bannerlists/{recovery?}', 'GoodsController@get_goods_bannerlists');
        $set->get('goods_banneredit/{id}', 'GoodsController@get_goods_banneredit');
        $set->post('goods_banneredit', 'GoodsController@post_goods_banneredit');
    });

    //導入情報
    Route::group(['prefix' => 'imports'], function ($set) {
        $set->get('recedents_add', 'ImportsController@get_recedents_add');
        $set->post('recedents_regist', 'ImportsController@post_recedents_regist');
        $set->get('recedents_lists/{recovery?}', 'ImportsController@get_recedents_lists');
        $set->get('recedents_edit/{id}', 'ImportsController@get_recedents_edit');
        $set->post('recedents_edit', 'ImportsController@post_recedents_edit');

        $set->get('company_add', 'ImportsController@get_company_add');
        $set->post('company_regist', 'ImportsController@post_company_regist');
        $set->get('company_lists/{recovery?}', 'ImportsController@get_company_lists');
        $set->get('company_edit/{id}', 'ImportsController@get_company_edit');
        $set->post('company_edit', 'ImportsController@post_company_edit');

        $set->get('lable_add', 'ImportsController@get_lable_add');
        $set->post('lable_regist', 'ImportsController@post_lable_regist');
        $set->get('lable_lists/{recovery?}', 'ImportsController@get_lable_lists');
        $set->get('lable_edit/{id}', 'ImportsController@get_lable_edit');
        $set->post('lable_edit', 'ImportsController@post_lable_edit');
    });

    //新着情報
    Route::group(['prefix' => 'news'], function ($set) {
        $set->get('news_add', 'NewsController@get_news_add');
        $set->post('news_regist', 'NewsController@post_news_regist');
        $set->get('news_lists/{recovery?}', 'NewsController@get_news_lists');
        $set->get('news_edit/{id}', 'NewsController@get_news_edit');
        $set->post('news_edit', 'NewsController@post_news_edit');
    });

    //セミナー展示会情報
    Route::group(['prefix' => 'seminar'], function ($set) {
        $set->get('exhibition_add', 'SeminarController@get_exhibition_add');
        $set->post('exhibition_regist', 'SeminarController@post_exhibition_regist');
        $set->get('exhibition_lists/{recovery?}', 'SeminarController@get_exhibition_lists');
        $set->get('exhibition_edit/{id}', 'SeminarController@get_exhibition_edit');
        $set->post('exhibition_edit', 'SeminarController@post_exhibition_edit');

        $set->get('teacher_add', 'SeminarController@get_teacher_add');
        $set->post('teacher_regist', 'SeminarController@post_teacher_regist');
        $set->get('teacher_lists/{recovery?}', 'SeminarController@get_teacher_lists');
        $set->get('teacher_edit/{id}', 'SeminarController@get_teacher_edit');
        $set->post('teacher_edit', 'SeminarController@post_teacher_edit');

        $set->get('lable_add', 'SeminarController@get_lable_add');
        $set->post('lable_regist', 'SeminarController@post_lable_regist');
        $set->get('lable_lists/{recovery?}', 'SeminarController@get_lable_lists');
        $set->get('lable_edit/{id}', 'SeminarController@get_lable_edit');
        $set->post('lable_edit', 'SeminarController@post_lable_edit');
    });

    //運営サイト情報
    Route::group(['prefix' => 'management'], function ($set) {
        $set->get('site_add', 'ManagementController@get_site_add');
        $set->post('site_regist', 'ManagementController@post_site_regist');
        $set->get('site_lists/{recovery?}', 'ManagementController@get_site_lists');
        $set->get('site_edit/{id}', 'ManagementController@get_site_edit');
        $set->post('site_edit', 'ManagementController@post_site_edit');
    });

    //ダウンロード情報
    Route::group(['prefix' => 'download'], function ($set) {
        $set->get('file_add', 'DownloadController@get_file_add');
        $set->post('file_regist', 'DownloadController@post_file_regist');
        $set->get('file_lists/{recovery?}', 'DownloadController@get_file_lists');
        $set->get('file_edit/{id}', 'DownloadController@get_file_edit');
        $set->post('file_edit', 'DownloadController@post_file_edit');

        $set->get('category_add', 'DownloadController@get_category_add');
        $set->post('category_regist', 'DownloadController@post_category_regist');
        $set->get('category_lists/{recovery?}', 'DownloadController@get_category_lists');
        $set->get('category_edit/{id}', 'DownloadController@get_category_edit');
        $set->post('category_edit', 'DownloadController@post_category_edit');

        $set->get('history_lists/{recovery?}', 'DownloadController@get_history_lists');
        $set->get('history_edit/{id}', 'DownloadController@get_history_edit');
    });
});


