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
                            <h3 class="card-title">{{$clients_info}} 权限设置</h3>
                        </div>
                            <div class="card-body">
                                @foreach($right_categories as $category=>$right_categorie)
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input type="checkbox" @if ($right_categorie['HAS_RIGHT'] != 0) checked @endif class="custom-control-input" name="role" value="{{$category}}" id="has_{{$category}}">
                                            <label class="custom-control-label" for="has_{{$category}}">{{$right_categorie[0]}}@if(isset($right_categorie[1]))_{{$right_categorie[1]}} @endif</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="/userinfo/admin_user_info" class="btn btn-secondary">返回上一页</a>
                                <button type="submit" id='btn-apply' class="btn btn-success float-right">
                                    提交设定
                                </button>
                            </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <script type="text/javascript">
        var params = {};
        var user_role_code={{$admin_user_role_code}};
        var seq_no={{$admin_seq_no}};

        $(function(){
            $('#btn-apply').click(function(){
                var arr = new Array();
                $("input:checkbox[name='role']:checked").each(function() {
                    arr.push($(this).val());
                });
                $.confirm({
                    title: false,
                    theme: 'white',
                    content: '账户 {{$clients_info}} 权限更新。\n是否立即执行?',
                    confirmButton: '确认',
                    cancelButton: '取消',
                    confirmButtonClass: 'btn-info',
                    cancelButtonClass: 'btn-danger',
                    confirm: function(){
                        params.ROLE_NAME = 'ROLE_'+"{!!$clients_info!!}";
                        params.RIGHTS = {};
                        params.RIGHTS[0] = '';
                        selectBox = document.getElementById("s2");
                        for (var i = 0; i < arr.length; i++)
                        {
                            params.RIGHTS[i] = arr[i];
                        }

                        var url = '/api/admins/user_rights_setting?ADMIN_ROLE_CODE='+user_role_code+'&ADMIN_SEQ_NO='+seq_no;
                        ajax.post(url, params, function(data){
                            $.alert({title: false,
                                theme: 'white',
                                content: '权限信息已经更新成功了',
                                confirmButton: '确认',
                                confirmButtonClass: 'btn-info'});
                        });

                    },
                });
            });
        });
    </script>
@endsection
