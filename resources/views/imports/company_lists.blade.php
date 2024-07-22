@extends('main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>導入企業一覧</h1>
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
                                    <button type="button" onclick="location.href='/imports/company_add'"
                                            class="btn btn-block btn-success">情報登録
                                    </button>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form id="search-form" action="/imports/company_lists" style="margin-bottom: 1%">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>企業名</label>
                                                <input type="text" value="{{ $c_name }}" placeholder="企業名" name="c_name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>タグ</label>
                                                <select class="select2 form-control" id="c_lables" name="c_lables[]" multiple="multiple" data-placeholder="選択してください">
                                                    @if (isset($S_PRODECT_LABLES))
                                                        @foreach($S_PRODECT_LABLES as $val)
                                                            <option value="{{$val['id']}}">{{$val['p_name']}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" @if ($open_flg == 1) checked @endif name="open_flg" id="open_flg" value="1">
                                                    <label for="open_flg" class="custom-control-label">公開中のみ表示する</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" @if ($precedents_url_have == 1) checked @endif name="precedents_url_have" id="precedents_url_have" value="1">
                                                    <label for="precedents_url_have" class="custom-control-label">導入事例URLがあり</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" @if ($video_url_have == 1) checked @endif name="video_url_have" id="video_url_have" value="1">
                                                    <label for="video_url_have" class="custom-control-label">紹介動画URLがあり</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">検索</button>
                                </form>
                                <table id="table_show" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>企業名</th>
                                        <th>導入事例URL</th>
                                        <th>紹介動画URL</th>
                                        <th>タグ</th>
                                        <th>公開フラグ</th>
                                        <th>作成時間</th>
                                        <th>アクション</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($info as $v)
                                        <tr>
                                            <td>{{$v['c_name']}}</td>
                                            <td style="text-align: center"><a href="{{$v['precedents_url']}}" target="_blank"><img src="{{ asset('assets/img/products_i03.png') }}"></a></td>
                                            <td style="text-align: center"><a href="{{$v['video_url']}}" target="_blank"><img src="{{ asset('assets/img/products_i02.png') }}"></a></td>
                                            <td>{{$v['c_lables_str']}}</td>
                                            <td>{{$v['open_flg_str']}}</td>
                                            <td>{{empty($v['CREATED_DT'])?'-':$v['CREATED_DT']}}</td>
                                            <td>
                                                <a style="margin-left: 3%" class="btn btn-info btn-sm" href="#"
                                                   onclick="location.href='/imports/company_edit/{{$v['id']}}'">
                                                    <i class="fas fa-pencil-alt"></i> 編集
                                                </a>
                                                <a style="margin-left: 3%" class="btn btn-danger btn-sm" href="#"
                                                   onClick="del({{$v['id']}}, '{{$v['c_name']}}');">
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
                    var url = "/api/imports/company_delete";
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
                            //         location.href = "/imports/company_lists";
                            //     }
                            // });
                            location.href = "/imports/company_lists?msg_code=200&&msg="+'企業情報の削除が完了しました。';
                        } else {
                            // $.alert({
                            //     title: false,
                            //     theme: 'white',
                            //     content: data['MESSAGE'],
                            //     confirmButton: 'OK',
                            //     confirmButtonClass: 'btn-info',
                            // });
                            location.href = "/imports/company_lists?msg_code=201&&msg="+data['MESSAGE'];
                        }
                    });
                },
            });
        };
    </script>
@endsection
