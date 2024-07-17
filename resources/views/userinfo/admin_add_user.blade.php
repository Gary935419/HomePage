@extends('main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>アカウント管理</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">アカウント追加</h3>
                        </div>
                        <form class="form-horizontal" action='/userinfo/admin_add_user' method='post'>
                            <div class="card-body">
                                @if(isset($add_user_result))
                                    <font size="2" color="#ff0000">{{$add_user_result}}</font> <br> <br>
                                @endif
                                @if(isset($created_user_id))
                                    <font size="2" color="#28a745">アカウント　{{$created_user_id}}　追加された。</font> <br> <br>
                                @endif
                                <div class="form-group">
                                    <label for="inputName">ログインID</label>
                                    <input type="text" id="user_id" size="16" name="USER_ID" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="inputName">アカウント名</label>
                                    <input type="text" id="user_name" size="16" name="USER_NAME" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="inputName">管理権限</label><br>
                                    <div class="icheck-primary d-inline">
                                        <input type="radio" id="radioPrimary1" name="USER_IDENTITY" value="0" checked>
                                        <label for="radioPrimary1">
                                            一般
                                        </label>
                                    </div>
                                    <div class="icheck-primary d-inline" style="margin-left: 2%">
                                        <input type="radio" id="radioPrimary2" name="USER_IDENTITY" value="1">
                                        <label for="radioPrimary2">
                                            管理者
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputClientCompany">パスワード</label>
                                    <input id="new_password" type="password" size="16" name="PASSWORD"
                                           class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="inputClientCompany">パスワードの再入力</label>
                                    <input id="new_password_confirm" type="password" size="16" name="PASSWORD_CONFIRM"
                                           class="form-control">
                                </div>
                                {{--                                <div class="form-group">--}}
                                {{--                                    <label for="inputDescription">Project Description</label>--}}
                                {{--                                    <textarea id="inputDescription" class="form-control" rows="4"></textarea>--}}
                                {{--                                </div>--}}
                                {{--                                <div class="form-group">--}}
                                {{--                                    <label for="inputStatus">Status</label>--}}
                                {{--                                    <select id="inputStatus" class="form-control custom-select">--}}
                                {{--                                        <option selected disabled>Select one</option>--}}
                                {{--                                        <option>On Hold</option>--}}
                                {{--                                        <option>Canceled</option>--}}
                                {{--                                        <option>Success</option>--}}
                                {{--                                    </select>--}}
                                {{--                                </div>--}}

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="/userinfo/admin_user_info" class="btn btn-secondary">戻る</a>
                                <button type="submit" id="btn_change_password" class="btn btn-success float-right">
                                    登録
                                </button>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
