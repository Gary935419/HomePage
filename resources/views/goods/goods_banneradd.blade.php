@extends('main')
@section('content')
    <style>
        .img_b_url {
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
        .img_b_url img {
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
                        <h1>バナー情報</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        @if(isset($MSG_CODE) && $MSG_CODE == 201)
            <div class="card-body">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i>おしらせ!</h5>
                    {{$MSG}}
                </div>
            </div>
        @endif
        @if(isset($MSG_CODE) && $MSG_CODE == 200)
            <div class="card-body">
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i>おしらせ!</h5>
                    {{$MSG}}
                </div>
            </div>
        @endif
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
                        <form enctype="multipart/form-data" action="/goods/goods_bannerregist" method="post" id="form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">バナー名</label>
                                    <input type="text" class="form-control" id="b_name" name="b_name" placeholder="バナー名">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputFile">バナー画像</label>
                                    <div class="custom-file">
                                        <input type="hidden" name="b_url" id="b_url" class="custom-file-input">
                                        <label class="custom-file-label" for="customFile" id="upload_b_url">ファイルを選択</label>
                                    </div>
                                    <img class="layui-upload-img" style="width:100px;height:100px;display: none;margin-top: 1%" id="b_url_img" name="b_url_img">
                                </div>
                                <div class="img_b_url"><img src="" alt=""></div>

                                <div class="form-group">
                                    <label>公開フラグ</label>
                                    <select class="form-control select2" name="b_flg" id="b_flg" style="width: 100%;">
                                        <option selected="selected" value="0">公開</option>
                                        <option value="1">未公開</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">リンク先URL</label>
                                    <input type="text" class="form-control" id="link_url" name="link_url" placeholder="リンク先URL">
                                </div>

{{--                                <div class="form-group">--}}
{{--                                    <label for="exampleInputEmail1">順番Number</label>--}}
{{--                                    <input type="number" class="form-control" id="b_sort" name="b_sort" placeholder="順番Number">--}}
{{--                                </div>--}}

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <a href="/goods/goods_bannerlists" class="btn btn-secondary">戻る</a>
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
        layui.use('upload', function(){
            var $ = layui.jquery
                ,upload = layui.upload;
            var url = '/api/upload/pushFIle';
            //普通图片上传
            var uploadInst = upload.render({
                elem: '#upload_b_url'
                ,url: url
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#b_url_img').attr('src', result); //图片链接（base64）
                        var img = document.getElementById("b_url_img");
                        img.style.display="block";
                    });
                }
                ,done: function(res){
                    if(res.STATUS == 0){
                        $("#upload_b_url").html(res.SRC);
                        $('#b_url').val(res.SRC); //图片链接（base64）
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
            $('#b_url_img').click(function(){
                var imgs = this;
                var imgSrc=$(imgs).attr("src");
                $(".img_b_url img").attr("src",imgSrc);
                $(".img_b_url").css("display","-webkit-box");
            });

            $(".img_b_url").click(function(){
                var box = this;
                $(box).find("img").attr("src","");
                $(box).hide();
            });

            $('#submit_btn').click(function() {
                var errors_text = "";
                if ($('#b_name').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "バナー名を入力してください。";
                }
                if ($('#b_url').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "バナー画像を入力してください。";
                }
                if ($('#link_url').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "リンク先URLを入力してください。";
                }
                if (!isValidHttpUrl($('#link_url').val())) {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "リンク先URLは無効です。";
                }
                // if ($('#b_sort').val() == "") {
                //     errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "順番Numberを入力してください。";
                // }

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
        function isValidHttpUrl(string) {
            try {
                const newUrl = new URL(string);
                return newUrl.protocol === 'http:' || newUrl.protocol === 'https:';
            } catch (err) {
                return false;
            }
        }
    </script>
@endsection
