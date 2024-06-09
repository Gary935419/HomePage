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
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <button type="button" onclick="location.href='/userinfo/admin_add_user'"
                                            class="btn btn-block btn-success">账户添加
                                    </button>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="table_show" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>账户</th>
                                        <th>最近登录时间</th>
                                        <th>创建时间</th>
                                        <th>权限信息</th>
                                        <th>重置操作</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if ($USER_ID === "admin")
                                        @foreach($clients_info as $client_info)
                                            <tr>
                                                <td id="USER_{{$client_info['USER_ID']}}">{{$client_info['USER_ID']}}</td>
                                                <td>{{empty($client_info['LAST_LOGIN'])?'-':$client_info['LAST_LOGIN']}}</td>
                                                <td>{{empty($client_info['CREATED_DT'])?'-':$client_info['CREATED_DT']}}</td>
                                                <td>
                                                    <a class="btn btn-primary btn-sm" href="#"
                                                       onclick="location.href='/userinfo/admin_user_rights_setting?ADMIN_SEQ_NO={{$client_info['SEQ_NO']}}&ADMIN_ROLE_CODE={{$client_info['ROLE_TYPE']}}'">
                                                        <i class="fas fa-pencil-alt"></i> 权限设置
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="btn btn-info btn-sm" href="#"
                                                       onclick="location.href='/userinfo/force_password_change?client_seq={{$client_info['SEQ_NO']}}'">
                                                        <i class="fas fa-pencil-alt"></i> 重置密码
                                                    </a>
                                                </td>
                                                <td>
                                                    @if ($client_info['USER_ID'] != "admin")
                                                        <a class="btn btn-danger btn-sm" href="#"
                                                           onClick="onUserRemove({{$client_info['SEQ_NO']}}, '{{$client_info['USER_ID']}}');"
                                                           value="{{$client_info['SEQ_NO']}}">
                                                            <i class="fas fa-trash"></i> 立即删除
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @foreach($clients_info as $client_info)
                                            <tr>
                                                @if ($client_info['USER_ID'] != "admin")
                                                    <td id="USER_{{$client_info['USER_ID']}}">{{$client_info['USER_ID']}}</td>
                                                    <td>{{empty($client_info['LAST_LOGIN'])?'-':$client_info['LAST_LOGIN']}}</td>
                                                    <td>{{empty($client_info['CREATED_DT'])?'-':$client_info['CREATED_DT']}}</td>
                                                    <td>
                                                        <a class="btn btn-primary btn-sm" href="#"
                                                           onclick="location.href='/userinfo/admin_user_rights_setting?ADMIN_SEQ_NO={{$client_info['SEQ_NO']}}&ADMIN_ROLE_CODE={{$client_info['ROLE_TYPE']}}'">
                                                            <i class="fas fa-pencil-alt"></i> 权限设置
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm" href="#"
                                                           onclick="location.href='/userinfo/force_password_change?client_seq={{$client_info['SEQ_NO']}}'">
                                                            <i class="fas fa-pencil-alt"></i> 重置密码
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-danger btn-sm" href="#"
                                                           onClick="onUserRemove({{$client_info['SEQ_NO']}}, '{{$client_info['USER_ID']}}');"
                                                           value="{{$client_info['SEQ_NO']}}">
                                                            <i class="fas fa-trash"></i> 立即删除
                                                        </a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>账户</th>
                                        <th>最近登录时间</th>
                                        <th>创建时间</th>
                                        <th>权限信息</th>
                                        <th>重置操作</th>
                                        <th>操作</th>
                                    </tr>
                                    </tfoot>
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
                content: '账户 ' + user_id + ' 是否删除?',
                confirmButton: '确认',
                cancelButton: '取消',
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
