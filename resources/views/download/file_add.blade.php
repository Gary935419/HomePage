@extends('main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>ファイル情報</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form enctype="multipart/form-data" action="/download/file_regist" method="post" id="form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">ファイル名</label>
                                    <input type="text" class="form-control" id="d_file_name" name="d_file_name" placeholder="ファイル名">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputFile">ファイル</label>
                                    <div class="custom-file">
                                        <input type="hidden" name="d_file_url" id="d_file_url" class="custom-file-input">
                                        <label class="custom-file-label" for="customFile" id="upload_d_file_url">ファイルを選択</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>カテゴリ</label>
                                    <select class="select2" id="d_category" name="d_category[]" multiple="multiple" data-placeholder="選択してください" style="width: 100%;">
                                        @if (isset($S_DOWNLOADS_CATEGORY))
                                            @foreach($S_DOWNLOADS_CATEGORY as $val)
                                                <option value="{{$val['id']}}">{{$val['category_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>確認フラグ</label>
                                    <select class="form-control select2" name="confirm_flg" id="confirm_flg" style="width: 100%;">
                                        <option selected="selected" value="0">未確認</option>
                                        <option value="1">確認完了</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>公開フラグ</label>
                                    <select class="form-control select2" name="open_flg" id="open_flg" style="width: 100%;">
                                        <option selected="selected" value="0">公開</option>
                                        <option value="1">未公開</option>
                                    </select>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="/download/file_lists" class="btn btn-secondary">戻る</a>
                                <button type="button" id="submit_btn" class="btn btn-success float-right">
                                    登録
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <script>
        $(function () {
            $('.select2').select2()
        });
    </script>
    <script>
        layui.use('upload', function(){
            var $ = layui.jquery
                ,upload = layui.upload;
            var url = '/api/upload/pushFIle';
            //上传文件
            upload.render({
                elem: '#upload_d_file_url'
                ,url: url
                ,field:"file"
                ,data:{"dir":"media"}
                ,accept: 'file'
                ,done: function(res){
                    if(res.STATUS == 0){
                        $("#d_file_url").val(res.SRC);
                        $("#upload_d_file_url").html(res.SRC);
                        return layer.msg('アップロード成功');
                    }else {
                        return layer.msg('アップロード失敗');
                    }
                }
            });
        });
    </script>

    <script>
        $(function() {

            $('#submit_btn').click(function() {
                var errors_text = "";
                if ($('#d_file_url').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "ファイルを選択してください。";
                }
                if ($('#d_file_name').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "ファイル名を入力してください。";
                }
                if ($('#d_category').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "カテゴリを入力してください。";
                }

                if (strlen(errors_text) > 0) {
                    $.alert({
                        title: false,
                        theme: 'white',
                        content: errors_text,
                        confirmButton: 'はい',
                        confirmButtonClass: 'btn-info',
                    });
                    return false;
                }

                var confirm_text = '登録してよろしいですか？';

                $.confirm({
                    title: false,
                    theme: 'white',
                    content: confirm_text,
                    confirmButton: 'はい',
                    cancelButton: 'いいえ',
                    confirmButtonClass: 'btn-info',
                    cancelButtonClass: 'btn-danger',
                    confirm: function() {
                        $("#submit_btn").attr('disabled', true);
                        $('#form').submit();
                    },
                });
            });
        });
    </script>
@endsection
