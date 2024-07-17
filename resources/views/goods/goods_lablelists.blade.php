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
                                    <button type="button" onclick="location.href='/goods/goods_lableadd'"
                                            class="btn btn-block btn-success">情報登録
                                    </button>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form id="search-form" action="/goods/goods_lablelists" style="margin-bottom: 1%">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>タグ名</label>
                                                <input type="text" value="{{ $pr_name }}" placeholder="タグ名" name="pr_name" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">検索</button>
                                </form>
                                <table id="table_show" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>タグ名</th>
                                        <th>作成時間</th>
                                        <th>アクション</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($info as $v)
                                        <tr>
                                            <td>{{$v['pr_name']}}</td>
                                            <td>{{empty($v['CREATED_DT'])?'-':$v['CREATED_DT']}}</td>
                                            <td>
                                                <a style="margin-left: 3%" class="btn btn-info btn-sm" href="#"
                                                   onclick="location.href='/goods/goods_lableedit/{{$v['id']}}'">
                                                    <i class="fas fa-pencil-alt"></i> 編集
                                                </a>
                                                <a style="margin-left: 3%" class="btn btn-danger btn-sm" href="#"
                                                   onClick="del({{$v['id']}}, '{{$v['pr_name']}}');">
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
            $("#table_show").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,"searching":false,
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
                    var url = "/api/goods/goods_labledelete";
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
                                    location.href = "/goods/goods_lablelists";
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
