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
        @if(isset($MSG_CODE) && $MSG_CODE == 201)
            <div class="card-body">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i>おしらせ!</h5>
                    {{$MSG}}
                </div>
            </div>
        @endif
        @if(isset($MSG_CODE) && $MSG_CODE == 200)
            <div class="card-body">
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i>おしらせ!</h5>
                    {{$MSG}}
                </div>
            </div>
        @endif
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">アカウント更新</h3>
                        </div>
                        <form class="form-horizontal" action='/userinfo/admin_edit_user' method='post'>
                            <div class="card-body">
{{--                                @if(isset($add_user_result))--}}
{{--                                    <font size="2" color="#ff0000">{{$add_user_result}}</font> <br> <br>--}}
{{--                                @endif--}}
{{--                                @if(isset($created_user_id))--}}
{{--                                    <font size="2" color="#28a745">アカウント　{{$created_user_id}}　更新された。</font> <br> <br>--}}
{{--                                @endif--}}
                                <div class="form-group">
                                    <label for="inputName">ログインID</label>
                                    <input type="text" id="user_id" size="16" value="{{ $info['USER_ID'] }}" name="USER_ID" autocomplete="off" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="inputName">アカウント名</label>
                                    <input type="text" id="user_name" size="16" value="{{ $info['USER_NAME'] }}" name="USER_NAME" autocomplete="off" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="inputName">管理権限</label><br>
                                    <div class="icheck-primary d-inline">
                                        <input type="radio" id="radioPrimary1" name="USER_IDENTITY" @if ($info['USER_IDENTITY']==0) checked @endif value="0" >
                                        <label for="radioPrimary1">
                                            一般
                                        </label>
                                    </div>
                                    <div class="icheck-primary d-inline" style="margin-left: 2%">
                                        <input type="radio" id="radioPrimary2" name="USER_IDENTITY" @if ($info['USER_IDENTITY']==1) checked @endif value="1">
                                        <label for="radioPrimary2">
                                            管理者
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputClientCompany">パスワード</label>
                                    <input id="new_password" type="password" size="16" autocomplete="new-password" name="PASSWORD"
                                           class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="inputClientCompany">パスワードの再入力</label>
                                    <input id="new_password_confirm" type="password" size="16" autocomplete="new-password" name="PASSWORD_CONFIRM"
                                           class="form-control">
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <input type="hidden" value="{{ $info['SEQ_NO'] }}" name="SEQ_NO" id="SEQ_NO">
                                <a href="/userinfo/admin_user_info" class="btn btn-secondary">戻る</a>
                                <button type="submit" id="btn_change_password" class="btn btn-success float-right">
                                    更新
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
