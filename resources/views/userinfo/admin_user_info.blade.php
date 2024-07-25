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
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <button type="button" onclick="location.href='/userinfo/admin_add_user'"
                                            class="btn btn-block btn-success">アカウント追加
                                    </button>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form id="search-form" action="/userinfo/admin_user_info" style="margin-bottom: 1%">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>ログインID</label>
                                                <input type="text" value="{{ $USER_ID }}" placeholder="ログインID" name="USER_ID" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>アカウント名</label>
                                                <input type="text" value="{{ $USER_NAME_NOW }}" placeholder="アカウント名" name="USER_NAME" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">検索</button>
                                </form>
                                <table id="table_show" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ログインID</th>
                                        <th>アカウント名</th>
                                        <th>最終ログイン時間</th>
                                        <th>作成時間</th>
                                        <th>アクション</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($clients_info as $client_info)
                                        <tr>
                                            <td id="USER_{{$client_info['USER_ID']}}">{{$client_info['USER_ID']}}</td>
                                            <td>{{$client_info['USER_NAME']}}</td>
                                            <td>{{empty($client_info['LAST_LOGIN'])?'-':$client_info['LAST_LOGIN']}}</td>
                                            <td>{{empty($client_info['CREATED_DT'])?'-':$client_info['CREATED_DT']}}</td>
                                            <td>
{{--                                                <a class="btn btn-primary btn-sm" href="#"--}}
{{--                                                   onclick="location.href='/userinfo/admin_user_rights_setting?ADMIN_SEQ_NO={{$client_info['SEQ_NO']}}&ADMIN_ROLE_CODE={{$client_info['ROLE_TYPE']}}'">--}}
{{--                                                    <i class="fas fa-pencil-alt"></i> 権限設定--}}
{{--                                                </a>--}}
{{--                                                <a style="margin-left: 3%" class="btn btn-info btn-sm" href="#"--}}
{{--                                                   onclick="location.href='/userinfo/force_password_change?client_seq={{$client_info['SEQ_NO']}}'">--}}
{{--                                                    <i class="fas fa-pencil-alt"></i> 編集--}}
{{--                                                </a>--}}
                                                <a style="margin-left: 3%" class="btn btn-info btn-sm" href="#"
                                                   onclick="location.href='/userinfo/admin_edit_user/{{$client_info['SEQ_NO']}}'">
                                                    <i class="fas fa-pencil-alt"></i> 編集
                                                </a>
                                                <a style="margin-left: 3%" class="btn btn-danger btn-sm" href="#"
                                                   onClick="onUserRemove({{$client_info['SEQ_NO']}}, '{{$client_info['USER_ID']}}', '{{$client_info['USER_NAME']}}');"
                                                   value="{{$client_info['SEQ_NO']}}">
                                                    <i class="fas fa-trash"></i> 削除
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
{{--                                    <tfoot>--}}
{{--                                    <tr>--}}
{{--                                        <th>アカウント</th>--}}
{{--                                        <th>最終ログイン時間</th>--}}
{{--                                        <th>作成時間</th>--}}
{{--                                        <th>操作</th>--}}
{{--                                    </tr>--}}
{{--                                    </tfoot>--}}
                                </table>
                            </div>
                            <!-- /.card-body -->
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
        $(function () {
            $("#table_show").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,"searching":false,"ordering":false
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                // "buttons": ["excel"]
            }).buttons().container().appendTo('#table_show_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script type="text/javascript">
        function onUserRemove(seq_no, user_id, user_name) {
            $.confirm({
                title: false,
                theme: 'white',
                content: user_name + 'さんのアカウントを削除してよろしいでしょうか?',
                confirmButton: 'はい',
                cancelButton: 'いいえ',
                confirmButtonClass: 'btn-danger',
                cancelButtonClass: 'btn-info',
                confirm: function () {
                    var url = '/userinfo/admin_remove_user?client_id=' + user_id;
                    location.href = url;
                },
            });
        };
    </script>
@endsection
