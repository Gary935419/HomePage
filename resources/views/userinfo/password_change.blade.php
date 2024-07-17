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
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">パスワードを変更</h3>
                            </div>
                            <!-- form start -->
                            <form class="form-horizontal" action='/userinfo/password_change' method='post'>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">現在のパスワード</label>
                                        <div class="col-sm-10">
                                            <input id="original_password" type="password" size="16"
                                                   name="ORIGINAL_PASSWORD" class="form-control"
                                                   placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-2 col-form-label">新しいパスワード</label>
                                        <div class="col-sm-10">
                                            <input id="new_password" type="password" size="16" name="NEW_PASSWORD"
                                                   onKeyUp="check_password()" class="form-control"
                                                   placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3"
                                               class="col-sm-2 col-form-label">新しいパスワードを再入力する</label>
                                        <div class="col-sm-10">
                                            <input id="new_password_confirm" class="form-control" type="password"
                                                   size="16" name="NEW_PASSWORD_CONFIRM" placeholder="Password"
                                                   onKeyUp="check_password()">
                                            <span id="new_password_confirm_status"></span>
                                        </div>
                                        <span id="new_password_confirm_status"
                                              style="font-size: 12px;color: #ff0000;padding:6px;">
                                                @if (isset($change_password_result))
                                                {{$change_password_result}}
                                            @endif</span>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" id="btn_change_password" disabled class="btn btn-info">
                                        変更
                                    </button>
                                </div>
                                <!-- /.card-footer -->
                            </form>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <script>
        var new_password = document.getElementById("new_password"),
            confirm_password = document.getElementById("new_password_confirm"),
            new_password_confirm_status = document.getElementById("new_password_confirm_status"),
            btn_change_password = document.getElementById("btn_change_password"),
            original_password = document.getElementById("original_password");
        btn_change_password.disabled = true;

        function check_password() {
            var pass = true;
            if (new_password.value == '' || confirm_password.value == '')
                return;
            if (new_password.value != confirm_password.value || original_password.value == '') {
                pass = false;
            }

            if (pass) {
                confirm_password.style.backgroundColor = "SpringGreen";
                new_password_confirm_status.innerHTML = "パスワード情報一致";
            } else {
                confirm_password.style.backgroundColor = "HotPink";
                new_password_confirm_status.innerHTML = "パスワード情報の不一致";
            }
            btn_change_password.disabled = !pass;
        }
    </script>
@endsection
