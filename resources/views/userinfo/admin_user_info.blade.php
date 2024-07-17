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
                                                <a class="btn btn-primary btn-sm" href="#"
                                                   onclick="location.href='/userinfo/admin_user_rights_setting?ADMIN_SEQ_NO={{$client_info['SEQ_NO']}}&ADMIN_ROLE_CODE={{$client_info['ROLE_TYPE']}}'">
                                                    <i class="fas fa-pencil-alt"></i> 権限設定
                                                </a>
                                                <a style="margin-left: 3%" class="btn btn-info btn-sm" href="#"
                                                   onclick="location.href='/userinfo/force_password_change?client_seq={{$client_info['SEQ_NO']}}'">
                                                    <i class="fas fa-pencil-alt"></i> パスワード変更
                                                </a>
                                                <a style="margin-left: 3%" class="btn btn-danger btn-sm" href="#"
                                                   onClick="onUserRemove({{$client_info['SEQ_NO']}}, '{{$client_info['USER_ID']}}');"
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
                "responsive": true, "lengthChange": false, "autoWidth": false,
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#table_show_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script type="text/javascript">
        function onUserRemove(seq_no, user_id) {
            $.confirm({
                title: false,
                theme: 'white',
                content: 'アカウント ' + user_id + ' 削除するかどうか?',
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
