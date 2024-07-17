@extends('main')
@section('content')
    <style>
        .img_logo {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: 99999999;
            background: rgba(0,0,0,.5);
            overflow: auto;
            -webkit-box-align: center;
            -webkit-box-pack: center;
        }
        .img_logo img {
            cursor: zoom-out;
        }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>運営情報</h1>
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
                        <form enctype="multipart/form-data" action="/management/site_regist" method="post" id="form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">タイトル</label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="タイトル">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputFile">バナー画像</label>
                                    <div class="custom-file">
                                        <input type="hidden" name="logo" id="logo" class="custom-file-input">
                                        <label class="custom-file-label" for="customFile" id="upload_logo">ファイルを選択</label>
                                    </div>
                                    <img class="layui-upload-img" style="width:100px;height:100px;display: none;margin-top: 1%" id="logo_img" name="logo_img">
                                </div>
                                <div class="img_logo"><img src="" alt=""></div>

                                <div class="form-group">
                                    <label>公開フラグ</label>
                                    <select class="form-control select2" name="open_flg" id="open_flg" style="width: 100%;">
                                        <option selected="selected" value="0">公開</option>
                                        <option value="1">未公開</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">説明</label>
                                    <div class="editor-container" style="width: 100%">
                                        <textarea class="form-control" id="contents" name="contents" placeholder="製品説明"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="/management/site_lists" class="btn btn-secondary">戻る</a>
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
            $('.select2').select2();
        });
    </script>
    <script>
        layui.use('upload', function(){
            var $ = layui.jquery
                ,upload = layui.upload;
            var url = '/api/upload/pushFIle';
            //普通图片上传
            var uploadInst = upload.render({
                elem: '#upload_logo'
                ,url: url
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#logo_img').attr('src', result); //图片链接（base64）
                        var img = document.getElementById("logo_img");
                        img.style.display="block";
                    });
                }
                ,done: function(res){
                    if(res.STATUS == 0){
                        $("#upload_logo").html(res.SRC);
                        $('#logo').val(res.SRC); //图片链接（base64）
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
            $('#logo_img').click(function(){
                var imgs = this;
                var imgSrc=$(imgs).attr("src");
                $(".img_logo img").attr("src",imgSrc);
                $(".img_logo").css("display","-webkit-box");
            });

            $(".img_logo").click(function(){
                var box = this;
                $(box).find("img").attr("src","");
                $(box).hide();
            });

            $('#submit_btn').click(function() {
                var errors_text = "";
                if ($('#title').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "タイトルを入力してください。";
                }
                if ($('#logo').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "ロゴ画像を入力してください。";
                }
                if ($('#contents').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "説明を入力してください。";
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
