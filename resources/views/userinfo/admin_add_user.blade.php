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
                    <h5 style="margin-bottom: 0rem;"><i class="icon fas fa-ban"></i>{{$MSG}}</h5>
                </div>
            </div>
        @endif
        @if(isset($MSG_CODE) && $MSG_CODE == 200)
            <div class="card-body">
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5 style="margin-bottom: 0rem;"><i class="icon fas fa-check"></i>{{$MSG}}</h5>
                </div>
            </div>
        @endif
        <div id="targetArea">
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">アカウント追加</h3>
                        </div>
                        <form class="form-horizontal" action='/userinfo/admin_add_user' method='post' id="form">
                            <div class="card-body">
{{--                                @if(isset($add_user_result))--}}
{{--                                    <font size="2" color="#ff0000">{{$add_user_result}}</font> <br> <br>--}}
{{--                                @endif--}}
{{--                                @if(isset($created_user_id))--}}
{{--                                    <font size="2" color="#28a745">アカウント　{{$created_user_id}}　追加された。</font> <br> <br>--}}
{{--                                @endif--}}
                                <div class="form-group">
                                    <label for="inputName">ログインID</label>
                                    <input type="text" id="USER_ID" size="16" name="USER_ID" autocomplete="off" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="inputName">アカウント名</label>
                                    <input type="text" id="USER_NAME" size="16" name="USER_NAME" autocomplete="off" class="form-control">
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
                                    <input id="PASSWORD" type="password" size="16" autocomplete="new-password" name="PASSWORD"
                                           class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="inputClientCompany">パスワードの再入力</label>
                                    <input id="PASSWORD_CONFIRM" type="password" size="16" autocomplete="new-password" name="PASSWORD_CONFIRM"
                                           class="form-control">
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="/userinfo/admin_user_info" class="btn btn-secondary">戻る</a>
                                <button type="button" id="submit_btn" class="btn btn-success float-right">
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

    <script>
        $(function() {
            $('#submit_btn').click(function() {
                var errors_text = "";
                if ($('#USER_ID').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・ログインIDを入力してください。";
                }
                if ($('#USER_NAME').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・アカウント名を入力してください。";
                }
                if ($('#PASSWORD').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・パスワードを入力してください。";
                }
                if ($('#PASSWORD_CONFIRM').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・パスワードの再入力を入力してください。";
                }

                if (strlen(errors_text) > 0) {
                    var divContent = "<div class='card-body'><div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <h5 style='margin-bottom: 0rem;'><i class='icon fas fa-ban'></i>入力情報が正しくありません。<br><span style='font-size: 15px;'>"+errors_text+"</span></h5> </div> </div>";
                    $('#targetArea').html(divContent);
                    $('html, body').animate({scrollTop: 0}, 'slow');
                    return false;
                }

                var confirm_text = '登録してよろしいですか？';

                $.confirm({
                    title: false,
                    theme: 'white',
                    content: confirm_text,
                    confirmButton: 'はい',
                    cancelButton: 'いいえ',
                    confirmButtonClass: 'btn-info',
                    cancelButtonClass: 'btn-danger',
                    confirm: function() {
                        $("#submit_btn").attr('disabled', true);
                        $('#form').submit();
                    },
                });
            });
        });
    </script>
@endsection
