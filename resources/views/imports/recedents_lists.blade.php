@extends('main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>事例一覧</h1>
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
                                    <button style="width: 15%" type="button" onclick="location.href='/imports/recedents_add'"
                                            class="btn btn-block btn-success">新規登録
                                    </button>
                                </div>
                                <div class="col-6 text-right">
                                    <button style="width:  18%;float: right" type="button" onclick="location.href='/imports/recedents_sort'"
                                            class="btn btn-block btn-warning">並び順設定
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form id="search-form" action="/imports/recedents_lists" style="margin-bottom: 1%">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>タイトル</label>
                                                <input type="text" value="{{ $pr_title }}" name="pr_title" placeholder="タイトル" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>会社名</label>
                                                <input type="text" value="{{ $guild_name }}" name="guild_name" placeholder="会社名" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>タグ</label>
                                                <select class="select2 form-control" id="pr_labels" name="pr_labels[]" multiple="multiple" data-placeholder="選択してください">
                                                    @if (isset($S_PRODECT_LABLES))
                                                        @foreach($S_PRODECT_LABLES as $val)
                                                            <option value="{{$val['id']}}">{{$val['p_name']}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">検索</button>
                                </form>
                                <table id="table_show" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>タイトル</th>
                                        <th>会社名</th>
                                        <th>タグ</th>
                                        <th>作成時間</th>
                                        <th width="15%">アクション</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($info as $v)
                                        <tr>
                                            <td>{{$v['pr_title']}}</td>
                                            <td>{{$v['guild_name']}}</td>
                                            <td>{{$v['pr_labels_str']}}</td>
                                            <td>{{empty($v['CREATED_DT'])?'-':$v['CREATED_DT']}}</td>
                                            <td>
                                                <a style="margin-left: 3%" class="btn btn-info btn-sm" href="#"
                                                   onclick="location.href='/imports/recedents_edit/{{$v['id']}}'">
                                                    <i class="fas fa-pencil-alt"></i> 編集
                                                </a>
                                                <a style="margin-left: 3%" class="btn btn-danger btn-sm" href="#"
                                                   onClick="del({{$v['id']}}, '{{$v['pr_title']}}');">
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
            var PRODECT_LABLES_ARR = @json($PRODECT_LABLES_ARR);
            $('#pr_labels').val(PRODECT_LABLES_ARR).trigger('change');
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
        function del(id, p_name) {
            $.confirm({
                title: false,
                theme: 'white',
                content: 'タイトル ' + p_name + ' 削除するかどうか?',
                confirmButton: 'はい',
                cancelButton: 'いいえ',
                confirmButtonClass: 'btn-danger',
                cancelButtonClass: 'btn-info',
                confirm: function () {
                    var url = "/api/imports/recedents_delete";
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
                            //         location.href = "/imports/recedents_lists";
                            //     }
                            // });
                            location.href = "/imports/recedents_lists?msg_code=200&&msg="+'事例情報の削除が完了しました。';
                        } else {
                            // $.alert({
                            //     title: false,
                            //     theme: 'white',
                            //     content: data['MESSAGE'],
                            //     confirmButton: 'OK',
                            //     confirmButtonClass: 'btn-info',
                            // });
                            location.href = "/imports/recedents_lists?msg_code=201&&msg="+data['MESSAGE'];
                        }
                    });
                },
            });
        };
    </script>
@endsection
