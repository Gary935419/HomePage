@extends('main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>製品一覧</h1>
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
                            <div class="card-header row">
                                <div class="col-6">
                                    <button style="width: 15%" type="button" onclick="location.href='/goods/goods_add'"
                                            class="btn btn-block btn-success">新規登録
                                    </button>
                                </div>
                                <div class="col-6 text-right">
                                    <button style="width:  18%;float: right" type="button" onclick="location.href='/goods/goods_sort'"
                                            class="btn btn-block btn-warning">並び順設定
                                    </button>
                                </div>
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
                                                <label>公開フラグ</label>
                                                <select id="p_open_flg" name="p_open_flg" class="form-control select2" style="width: 100%;">
                                                    <option value="0" selected>選択してください</option>
                                                    <option @if ($p_open_flg == 1) selected @endif value="1">未公開</option>
                                                    <option @if ($p_open_flg == 2) selected @endif value="2">公開</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" @if ($p_pdf_url_have == 1) checked @endif name="p_pdf_url_have" id="p_pdf_url_have" value="1">
                                                    <label for="p_pdf_url_have" class="custom-control-label">製品カタログ（PDF）があり</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" @if ($p_video_url_have == 1) checked @endif name="p_video_url_have" id="p_video_url_have" value="1">
                                                    <label for="p_video_url_have" class="custom-control-label">製品動画があり</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" @if ($p_special_weburl_have == 1) checked @endif name="p_special_weburl_have" id="p_special_weburl_have" value="1">
                                                    <label for="p_special_weburl_have" class="custom-control-label">特設サイトURLがあり</label>
                                                </div>
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
                                        <th width="15%">アクション</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($info as $v)
                                        <tr>
                                            <td>{{$v['p_name']}}</td>
                                            <td>{{$v['p_lables_str']}}</td>
                                            <td style="text-align: center">
                                                @if(!empty($v['p_pdf_url']))
                                                    <a href="{{$v['p_pdf_url']}}" target="_blank"><img style="width: 15%" src="{{ asset('assets/img/products_i01.png') }}"></a>
                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                @if(!empty($v['p_video_url']))
                                                    <a href="{{$v['p_video_url']}}" target="_blank"><img style="width: 15%" src="{{ asset('assets/img/products_i02.png') }}"></a>
                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                @if(!empty($v['p_special_weburl']))
                                                    <a href="{{$v['p_special_weburl']}}" target="_blank"><img style="width: 15%" src="{{ asset('assets/img/products_i03.png') }}"></a>
                                                @endif
                                            </td>
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
        });
    </script>
    <script>
        $(function () {
            $("#table_show").DataTable({
                language: {
                    "sProcessing": "処理中...",
                    "sLengthMenu": "_MENU_ 件表示",
                    "sZeroRecords": "データはありません。",
                    "sInfo": " _TOTAL_ 件中 _START_ から _END_ まで表示",
                    "sInfoEmpty": " 0 件中 0 から 0 まで表示",
                    "sInfoFiltered": "（全 _MAX_ 件より抽出）",
                    "sInfoPostFix": "",
                    "sSearch": "検索:",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "先頭",
                        "sPrevious": "前",
                        "sNext": "次",
                        "sLast": "最終"
                    }
                },
                "responsive": true, "lengthChange": false, "autoWidth": false,"searching":false,"ordering":false
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                // "buttons": ["excel"]
            }).buttons().container().appendTo('#table_show_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script type="text/javascript">
        function del(id, name) {
            $.confirm({
                title: false,
                theme: 'white',
                content: name + 'を削除してよろしいでしょうか？',
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
                            // $.alert({
                            //     title: false,
                            //     theme: 'white',
                            //     content: '削除処理完了。',
                            //     confirmButton: 'OK',
                            //     confirmButtonClass: 'btn-info',
                            //     confirm: function () {
                            //         location.href = "/goods/goods_lists";
                            //     }
                            // });
                            location.href = "/goods/goods_lists?msg_code=200&&msg="+'製品情報の削除が完了しました。';
                        } else {
                            // $.alert({
                            //     title: false,
                            //     theme: 'white',
                            //     content: data['MESSAGE'],
                            //     confirmButton: 'OK',
                            //     confirmButtonClass: 'btn-info',
                            // });
                            location.href = "/goods/goods_lists?msg_code=201&&msg="+data['MESSAGE'];
                        }
                    });
                },
            });
        };
    </script>
@endsection
