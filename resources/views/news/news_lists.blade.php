@extends('main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>ニュース一覧</h1>
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
                                    <button type="button" onclick="location.href='/news/news_add'"
                                            class="btn btn-block btn-success">情報登録
                                    </button>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form id="search-form" action="/news/news_lists" style="margin-bottom: 1%">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>キーワード</label>
                                                <input type="text" value="{{ $key_str }}" name="key_str" placeholder="キーワード" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>カテゴリ</label>
                                                <select class="select2 form-control" id="n_type_arr" name="n_type_arr[]" multiple="multiple" data-placeholder="選択してください">
                                                    <option value="1">新着情報</option>
                                                    <option value="2">セミナー展示会</option>
                                                    <option value="3">ニュースリリース</option>
                                                    <option value="4">メディア</option>
                                                    <option value="5">障害連絡</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>公開日</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                      <span class="input-group-text">
                                                        <i class="far fa-calendar-alt"></i>
                                                      </span>
                                                    </div>
                                                    <input type="text" value="{{ $D_FROM_D_TO }}" class="form-control float-right" name="reservation" id="reservation">
                                                    <input type="hidden" class="form-control float-right" name="D_FROM" id="D_FROM">
                                                    <input type="hidden" class="form-control float-right" name="D_TO" id="D_TO">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" @if ($n_open_flg == 1) checked @endif name="n_open_flg" id="n_open_flg" value="1">
                                                    <label for="n_open_flg" class="custom-control-label">公開中のみ表示する</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <button type="submit" class="btn btn-primary">検索</button>
                                </form>
                                <table id="table_show" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>タイトル</th>
                                        <th>カテゴリ</th>
                                        <th>公開フラグ</th>
                                        <th>公開日時</th>
                                        <th>終了日時</th>
                                        <th>作成時間</th>
                                        <th>アクション</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($info as $v)
                                        <tr>
                                            <td>{{$v['n_title']}}</td>
                                            <td>{{$v['type_name']}}</td>
                                            <td>{{$v['n_open_flg_str']}}</td>
                                            <td>{{empty($v['n_open_date'])?'-':$v['n_open_date']}}</td>
                                            <td>{{empty($v['n_close_date'])?'-':$v['n_close_date']}}</td>
                                            <td>{{empty($v['CREATED_DT'])?'-':$v['CREATED_DT']}}</td>
                                            <td>
                                                <a style="margin-left: 3%" class="btn btn-info btn-sm" href="#"
                                                   onclick="location.href='/news/news_edit/{{$v['id']}}'">
                                                    <i class="fas fa-pencil-alt"></i> 編集
                                                </a>
                                                <a style="margin-left: 3%" class="btn btn-danger btn-sm" href="#"
                                                   onClick="del({{$v['id']}}, '{{$v['n_title']}}');">
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
            var n_type_arr = @json($n_type_arr);
            $('#n_type_arr').val(n_type_arr).trigger('change');

            // Date range picker
            $('#reservation').daterangepicker({
                autoUpdateInput:false,
                locale: {
                    format: 'YYYY-MM-DD',
                    applyLabel: 'はい',
                    cancelLabel: 'いいえ',
                    daysOfWeek: ['日', '月', '火', '水', '木', '金', '土'],
                    monthNames: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                }
            }).on('cancel.daterangepicker',function (ev, picker) {
                $("#reservation").val("");
                $("#D_FROM").val("");
                $("#D_TO").val("");
            }).on('apply.daterangepicker',function (ev, picker) {
                $("#D_FROM").val(picker.startDate.format('YYYY-MM-DD'));
                $("#D_TO").val(picker.endDate.format('YYYY-MM-DD'));
                $("#reservation").val(picker.startDate.format('YYYY-MM-DD') + " - " + picker.endDate.format('YYYY-MM-DD'));
            })
        });

        $(function () {
            $("#table_show").DataTable({
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
                content: 'タイトル ' + name + ' 削除するかどうか?',
                confirmButton: 'はい',
                cancelButton: 'いいえ',
                confirmButtonClass: 'btn-danger',
                cancelButtonClass: 'btn-info',
                confirm: function () {
                    var url = "/api/news/news_delete";
                    var params = {};
                    params.id = id;

                    ajax.post(url, params, function(data) {
                        if (data['RESULT'] == "OK") {
                            location.href = "/news/news_lists?msg_code=200&&msg="+'ニュース情報の削除が完了しました。';
                        } else {
                            location.href = "/news/news_lists?msg_code=201&&msg="+data['MESSAGE'];
                        }
                    });
                },
            });
        };
    </script>
@endsection
