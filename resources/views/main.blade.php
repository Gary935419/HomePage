@extends('layouts.app')
@section('title', '東海電子')
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
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
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
        <a href="#" class="brand-link">
            <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">東海電子</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">


            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="/" class="nav-link @if (($controller ?? '') == 'Controller_Main' && $action == 'index') active @endif">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>控制台</p>
                        </a>
                    </li>
                    @if (isset($myrolls['userinfo']))
                        <li class="nav-item @if (($controller ?? '') == 'Controller_Userinfo') menu-open @endif">
                            <a href="#" class="nav-link @if (($controller ?? '') == 'Controller_Userinfo') active @endif">
                                <i class="nav-icon fas fa-solid fa-users"></i>
                                <p>
                                    账户管理
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if (array_search('password_change', $myrolls['userinfo']) !== false)
                                    <li class="nav-item">
                                        <a href="/userinfo/password_change" class="nav-link @if (($controller ?? '') == 'Controller_Userinfo' && $action == 'password_change') active @endif">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>修改密码</p>
                                        </a>
                                    </li>
                                @endif
                                @if (array_search('admin_user_info', $myrolls['userinfo']) !== false)
                                    <li class="nav-item">
                                        <a href="/userinfo/admin_user_info" class="nav-link @if (($controller ?? '') == 'Controller_Userinfo' && ($action == 'admin_user_info' || $action == 'force_password_change' || $action == 'admin_user_rights_setting')) active @endif">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>账户一览</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (isset($myrolls['goods']))
                        <li class="nav-item @if (($controller ?? '') == 'Controller_Goods') menu-open @endif">
                            <a href="#" class="nav-link @if (($controller ?? '') == 'Controller_Goods') active @endif">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    製品情報
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if (array_search('goods_add', $myrolls['goods']) !== false)
                                    <li class="nav-item">
                                        <a href="#" class="nav-link @if (($controller ?? '') == 'Controller_Goods' && $action == 'goods_add') active @endif">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>追加情報</p>
                                        </a>
                                    </li>
                                @endif
                                    @if (array_search('goods_lists', $myrolls['goods']) !== false)
                                    <li class="nav-item">
                                        <a href="#" class="nav-link @if (($controller ?? '') == 'Controller_Goods' && ($action == 'goods_lists')) active @endif">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>情報一览</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (isset($myrolls['setting']))
                        <li class="nav-item @if (($controller ?? '') == 'Controller_Setting') menu-open @endif">
                            <a href="#" class="nav-link @if (($controller ?? '') == 'Controller_Setting') active @endif">
                                <i class="nav-icon far fa-plus-square"></i>
                                <p>
                                    设置管理
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if (array_search('banner_add', $myrolls['setting']) !== false)
                                    <li class="nav-item">
                                        <a href="#" class="nav-link @if (($controller ?? '') == 'Controller_Setting' && $action == 'banner_add') active @endif">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Banner追加</p>
                                        </a>
                                    </li>
                                @endif
                                    @if (array_search('banner_lists', $myrolls['setting']) !== false)
                                    <li class="nav-item">
                                        <a href="#" class="nav-link @if (($controller ?? '') == 'Controller_Setting' && ($action == 'banner_lists')) active @endif">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Banner一览</p>
                                        </a>
                                    </li>
                                @endif
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
    <aside class="control-sidebar control-sidebar-dark" style="height: 160px">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">Welcome {{ $USER_ID ?? '' }}</a>
                </div>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            </form>
            <button type="button"  onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-block btn-danger">退出登录</button>
        </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- Default to the left -->
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->

</body>
@endsection
