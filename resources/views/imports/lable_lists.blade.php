@extends('main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>タグ一覧</h1>
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
                                    <button type="button" onclick="location.href='/imports/lable_add'"
                                            class="btn btn-block btn-success">情報登録
                                    </button>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form id="search-form" action="/imports/lable_lists" style="margin-bottom: 1%">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>タグ名</label>
                                                <input type="text" value="{{ $p_name }}" placeholder="タグ名" name="p_name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>カテゴリ</label>
                                                <select class="select2 form-control" id="p_type_arr" name="p_type_arr[]" multiple="multiple" data-placeholder="選択してください">
                                                    <option value="1">業種別</option>
                                                    <option value="2">点呼種別</option>
                                                    <option value="3">製品別</option>
                                                    <option value="4">その他</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">検索</button>
                                </form>
                                <table id="table_show" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>タグ名</th>
                                        <th>カテゴリ</th>
                                        <th>作成時間</th>
                                        <th>アクション</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($info as $v)
                                        <tr>
                                            <td>{{$v['p_name']}}</td>
                                            <td>{{$v['type_name']}}</td>
                                            <td>{{empty($v['CREATED_DT'])?'-':$v['CREATED_DT']}}</td>
                                            <td>
                                                <a style="margin-left: 3%" class="btn btn-info btn-sm" href="#"
                                                   onclick="location.href='/imports/lable_edit/{{$v['id']}}'">
                                                    <i class="fas fa-pencil-alt"></i> 編集
                                                </a>
                                                <a style="margin-left: 3%" class="btn btn-danger btn-sm" href="#"
                                                   onClick="del({{$v['id']}}, '{{$v['p_name']}}');">
                                                    <i class="fas fa-trash"></i> 削除
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
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
            $(function () {
                $('.select2').select2();
                var p_type_arr = @json($p_type_arr);
                $('#p_type_arr').val(p_type_arr).trigger('change');
            });
            $("#table_show").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,"searching":false,"ordering":false
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#table_show_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script type="text/javascript">
        function del(id, pr_name) {
            $.confirm({
                title: false,
                theme: 'white',
                content: 'タグ名 ' + pr_name + ' 削除するかどうか?',
                confirmButton: 'はい',
                cancelButton: 'いいえ',
                confirmButtonClass: 'btn-danger',
                cancelButtonClass: 'btn-info',
                confirm: function () {
                    var url = "/api/imports/lable_delete";
                    var params = {};
                    params.id = id;

                    ajax.post(url, params, function(data) {
                        if (data['RESULT'] == "OK") {
                            $.alert({
                                title: false,
                                theme: 'white',
                                content: '削除処理完了。',
                                confirmButton: 'OK',
                                confirmButtonClass: 'btn-info',
                                confirm: function () {
                                    location.href = "/imports/lable_lists";
                                }
                            });
                        } else {
                            $.alert({
                                title: false,
                                theme: 'white',
                                content: data['MESSAGE'],
                                confirmButton: 'OK',
                                confirmButtonClass: 'btn-info',
                            });
                        }
                    });
                },
            });
        };
    </script>
@endsection
