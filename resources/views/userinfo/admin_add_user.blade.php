@extends('main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>账户管理</h1>
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
                            <h3 class="card-title">账户添加</h3>
                        </div>
                        <form class="form-horizontal" action='/userinfo/admin_add_user' method='post'>
                            <div class="card-body">
                                @if(isset($add_user_result))
                                    <font size="2" color="#ff0000">{{$add_user_result}}</font> <br> <br>
                                @endif
                                @if(isset($created_user_id))
                                    <font size="2" color="#28a745">账户　{{$created_user_id}}　添加成功了。</font> <br> <br>
                                @endif
                                <div class="form-group">
                                    <label for="inputName">账户</label>
                                    <input type="text" id="user_id" size="16" name="USER_ID" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="inputClientCompany">密码</label>
                                    <input id="new_password" type="password" size="16" name="PASSWORD"
                                           class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="inputClientCompany">再次输入密码</label>
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
                                <a href="/userinfo/admin_user_info" class="btn btn-secondary">返回上一页</a>
                                <button type="submit" id="btn_change_password" class="btn btn-success float-right">
                                    确认提交
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
