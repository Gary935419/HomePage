@extends('layouts.app')
@section('title', '東海電子株式会社')
@section('content_top')
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item">

                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://www.tokai-denshi.co.jp/" role="button" target="_blank">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <div class="brand-link" style="display: block;padding: 1.5rem 0.1rem;transition: width .3s ease-in-out;white-space: nowrap;">
            <img src="{{ asset('assets/web_img/common/footer_logo.png') }}" class="brand-image elevation-3" style="float: left;margin-left: 1rem;margin-top: -10px;max-height: 25px;width: auto;">
            <span class="brand-text font-weight-light"></span>
        </div>

        <!-- Sidebar -->
        <div class="sidebar">


            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
{{--                    <li class="nav-item">--}}
{{--                        <a href="/admin" class="nav-link @if (($controller ?? '') == 'Controller_Main' && $action == 'index') active @endif">--}}
{{--                            <i class="nav-icon fas fa-tachometer-alt"></i>--}}
{{--                            <p>コンソール</p>--}}
{{--                        </a>--}}
{{--                    </li>--}}

                    <li class="nav-item @if (($controller ?? '') == 'Controller_News') menu-open @endif">
                        <a href="#" class="nav-link @if (($controller ?? '') == 'Controller_News') active @endif">
                            <i class="nav-icon fas fa-newspaper"></i>
                            <p>
                                新着情報
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/news/news_lists" class="nav-link @if (($controller ?? '') == 'Controller_News' && ($action == 'news_lists' || $action == 'news_edit' || $action == 'news_add' || $action == 'news_regist'))) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>ニュース一覧</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item @if (($controller ?? '') == 'Controller_Goods') menu-open @endif">
                        <a href="#" class="nav-link @if (($controller ?? '') == 'Controller_Goods') active @endif">
                            <i class="nav-icon fas fa-th-list"></i>
                            <p>
                                製品情報
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/goods/goods_lists" class="nav-link @if (($controller ?? '') == 'Controller_Goods' && ($action == 'goods_lists' || $action == 'goods_edit' || $action == 'goods_add' || $action == 'goods_regist'))) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>製品一覧</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/goods/goods_lablelists" class="nav-link @if (($controller ?? '') == 'Controller_Goods' && ($action == 'goods_lablelists' || $action == 'goods_lableedit' || $action == 'goods_lableadd' || $action == 'goods_lableregist'))) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>タグ一覧</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/goods/goods_bannerlists" class="nav-link @if (($controller ?? '') == 'Controller_Goods' && ($action == 'goods_bannerlists' || $action == 'goods_banneredit' || $action == 'goods_banneradd' || $action == 'goods_bannerregist'))) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>バナー一覧</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item @if (($controller ?? '') == 'Controller_Imports') menu-open @endif">
                        <a href="#" class="nav-link @if (($controller ?? '') == 'Controller_Imports') active @endif">
                            <i class="nav-icon fas fa-building"></i>
                            <p>
                                導入企業
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/imports/recedents_lists" class="nav-link @if (($controller ?? '') == 'Controller_Imports' && ($action == 'recedents_lists' || $action == 'recedents_edit' || $action == 'recedents_add' || $action == 'recedents_regist'))) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>導入事例一覧</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/imports/company_lists" class="nav-link @if (($controller ?? '') == 'Controller_Imports' && ($action == 'company_lists' || $action == 'company_edit' || $action == 'company_add' || $action == 'company_regist'))) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>導入企業一覧</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/imports/lable_lists" class="nav-link @if (($controller ?? '') == 'Controller_Imports' && ($action == 'lable_lists' || $action == 'lable_edit' || $action == 'lable_add' || $action == 'lable_regist'))) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>タグ一覧</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item @if (($controller ?? '') == 'Controller_Seminar') menu-open @endif">
                        <a href="#" class="nav-link @if (($controller ?? '') == 'Controller_Seminar') active @endif">
                            <i class="nav-icon fas fa-warehouse"></i>
                            <p>
                                セミナー展示会情報
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/seminar/exhibition_lists" class="nav-link @if (($controller ?? '') == 'Controller_Seminar' && ($action == 'exhibition_lists' || $action == 'exhibition_edit' || $action == 'exhibition_add' || $action == 'exhibition_regist'))) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>セミナー展示会一覧</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/seminar/teacher_lists" class="nav-link @if (($controller ?? '') == 'Controller_Seminar' && ($action == 'teacher_lists' || $action == 'teacher_edit' || $action == 'teacher_add' || $action == 'teacher_regist'))) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>講師一覧</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/seminar/lable_lists" class="nav-link @if (($controller ?? '') == 'Controller_Seminar' && ($action == 'lable_lists' || $action == 'lable_edit' || $action == 'lable_add' || $action == 'lable_regist'))) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>タグ一覧</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item @if (($controller ?? '') == 'Controller_Management') menu-open @endif">
                        <a href="#" class="nav-link @if (($controller ?? '') == 'Controller_Management') active @endif">
                            <i class="nav-icon fas fa-university"></i>
                            <p>
                                運営サイト情報
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/management/site_lists" class="nav-link @if (($controller ?? '') == 'Controller_Management' && ($action == 'site_lists' || $action == 'site_edit' || $action == 'site_add' || $action == 'site_regist'))) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>運営一覧</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item @if (($controller ?? '') == 'Controller_Download') menu-open @endif">
                        <a href="#" class="nav-link @if (($controller ?? '') == 'Controller_Download') active @endif">
                            <i class="nav-icon fas fa-file-powerpoint"></i>
                            <p>
                                ダウンロード情報
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/download/file_lists" class="nav-link @if (($controller ?? '') == 'Controller_Download' && ($action == 'file_lists' || $action == 'file_edit' || $action == 'file_add' || $action == 'file_regist'))) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>ファイル一覧</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/download/category_lists" class="nav-link @if (($controller ?? '') == 'Controller_Download' && ($action == 'category_lists' || $action == 'category_edit' || $action == 'category_add' || $action == 'category_regist'))) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>カテゴリ一覧</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/download/history_lists" class="nav-link @if (($controller ?? '') == 'Controller_Download' && ($action == 'history_lists'))) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>ダウンロード履歴</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    @if (!empty($USER_IDENTITY))
                        <li class="nav-item @if (($controller ?? '') == 'Controller_Userinfo') menu-open @endif">
                            <a href="#" class="nav-link @if (($controller ?? '') == 'Controller_Userinfo') active @endif">
                                <i class="nav-icon fas fa-solid fa-users"></i>
                                <p>
                                    アカウント管理
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/userinfo/admin_user_info" class="nav-link @if (($controller ?? '') == 'Controller_Userinfo' && ($action == 'admin_user_info' || $action == 'force_password_change' || $action == 'admin_user_rights_setting')) active @endif">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>アカウント一覧</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    @yield('content')
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark" style="height: 200px">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
{{--                <div class="image">--}}
{{--                    <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">--}}
{{--                </div>--}}
                <div class="info">
                    <a href="#" class="d-block">ようこそ、{{ $USER_NAME ?? '' }}さん!</a>
                </div>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            </form>
            <a href="/userinfo/password_change">
                <button type="button" class="btn btn-block btn-primary">パスワードを更新</button>
            </a>
            <button type="button" style="margin-top: 5%" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-block btn-danger">ログアウト</button>
        </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- Default to the left -->
        <strong>Copyright &copy; <a href="https://www.tokai-denshi.co.jp/" target="_blank">東海電子HP</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->

</body>
@endsection
