@extends('main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>情報一覧</h1>
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
                                    <button type="button" onclick="location.href='/goods/goods_add'"
                                            class="btn btn-block btn-success">情報登録
                                    </button>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form id="search-form" action="/goods/goods_lists" style="margin-bottom: 1%">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>製品名</label>
                                                <input type="text" value="{{ $p_name }}" placeholder="製品名" name="p_name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>タグ</label>
                                                <select class="select2 form-control" id="p_lables" name="p_lables[]" multiple="multiple" data-placeholder="選択してください">
                                                    @if (isset($S_PRODUCT_LABLES))
                                                        @foreach($S_PRODUCT_LABLES as $val)
                                                            <option value="{{$val['id']}}">{{$val['pr_name']}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>製品カタログURL</label>
                                                <input type="text" value="{{ $p_pdf_url }}" placeholder="製品カタログURL" name="p_pdf_url" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>製品動画URL</label>
                                                <input type="text" value="{{ $p_video_url }}" placeholder="製品動画URL" name="p_video_url" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>特設サイトURL</label>
                                                <input type="text" value="{{ $p_special_weburl }}" placeholder="特設サイトURL" name="p_special_weburl" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>公開フラグ</label>
                                                <select class="form-control select2" name="p_open_flg[]" id="p_open_flg" multiple="multiple" data-placeholder="選択してください">
                                                    <option value="0">公開</option>
                                                    <option value="1">未公開</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">検索</button>
                                </form>
                                <table id="table_show" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>製品名</th>
                                        <th>タグ</th>
                                        <th>製品カタログURL</th>
                                        <th>製品動画URL</th>
                                        <th>特設サイトURL</th>
                                        <th>公開フラグ</th>
                                        <th>作成時間</th>
                                        <th>アクション</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($info as $v)
                                        <tr>
                                            <td>{{$v['p_name']}}</td>
                                            <td>{{$v['p_lables_str']}}</td>
                                            <td>{{$v['p_pdf_url']}}</td>
                                            <td>{{$v['p_video_url']}}</td>
                                            <td>{{$v['p_special_weburl']}}</td>
                                            <td>{{$v['p_open_flg_str']}}</td>
                                            <td>{{empty($v['CREATED_DT'])?'-':$v['CREATED_DT']}}</td>
                                            <td>
                                                <a style="margin-left: 3%" class="btn btn-info btn-sm" href="#"
                                                   onclick="location.href='/goods/goods_edit/{{$v['id']}}'">
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
            $('.select2').select2();
            var PRODUCT_LABLES_ARR = @json($PRODUCT_LABLES_ARR);
            $('#p_lables').val(PRODUCT_LABLES_ARR).trigger('change');

            var OPEN_FLG_ARR = @json($OPEN_FLG_ARR);
            $('#p_open_flg').val(OPEN_FLG_ARR).trigger('change');
        });
        $(function () {
            $("#table_show").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,"searching":false,
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                // "buttons": ["excel"]
            }).buttons().container().appendTo('#table_show_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script type="text/javascript">
        function del(id, p_name) {
            $.confirm({
                title: false,
                theme: 'white',
                content: '製品名 ' + p_name + ' 削除するかどうか?',
                confirmButton: 'はい',
                cancelButton: 'いいえ',
                confirmButtonClass: 'btn-danger',
                cancelButtonClass: 'btn-info',
                confirm: function () {
                    var url = "/api/goods/goods_delete";
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
                                    location.href = "/goods/goods_lists";
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
