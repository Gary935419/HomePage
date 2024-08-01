@extends('main')
@section('content')
    <style>
        .img_p_logo {
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
        .img_p_logo img {
            cursor: zoom-out;
        }
        .img_p_main_img {
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
        .img_p_main_img img {
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
                        <h1>製品情報</h1>
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
        <div id="targetArea">
        </div>
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
                        <form enctype="multipart/form-data" action="/goods/goods_edit" method="post" id="form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">製品名<code> 必須</code></label>
                                    <input type="text" value="{{ $info['p_name'] }}" class="form-control" id="p_name" name="p_name" placeholder="製品名">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputFile">ロゴ画像<code> 必須、推奨サイズ（530px X 135px）</code></label>
                                    <div class="custom-file">
                                        <input type="hidden" value="{{ $info['p_logo'] }}" name="p_logo" id="p_logo" class="custom-file-input">
                                        <label class="custom-file-label" for="customFile" id="upload_p_logo">{{ $info['p_logo'] }}</label>
                                    </div>
                                    <img src="{{ $info['p_logo'] }}" class="layui-upload-img" style="width:100px;height:100px;margin-top: 1%" id="p_logo_img" name="p_logo_img">
                                </div>
                                <div class="img_p_logo"><img src="" alt=""></div>

                                <div class="form-group">
                                    <label for="exampleInputFile">メインイメージ<code> 必須、推奨サイズ（360px X 360px）</code></label>
                                    <div class="custom-file">
                                        <input type="hidden" value="{{ $info['p_main_img'] }}" name="p_main_img" id="p_main_img" class="custom-file-input">
                                        <label class="custom-file-label" for="customFile" id="upload_p_main_img">{{ $info['p_main_img'] }}</label>
                                    </div>
                                    <img src="{{ $info['p_main_img'] }}" class="layui-upload-img" style="width:100px;height:100px;margin-top: 1%" id="p_main_img_img" name="p_main_img_img">
                                </div>
                                <div class="img_p_main_img"><img src="" alt=""></div>

                                <div class="form-group">
                                    <label for="exampleInputFile">製品カタログ（PDF）<code> PDFのみ</code></label>
                                    <button type="button" onclick="return clear_p_pdf_url()" class="btn btn-warning" style="padding: 0.1rem 0.5rem;">
                                        クリア
                                    </button>
                                    <div class="custom-file">
                                        <input type="hidden" value="{{ $info['p_pdf_url'] }}" name="p_pdf_url" id="p_pdf_url" class="custom-file-input">
                                        <label class="custom-file-label" for="customFile" id="upload_p_pdf_url">{{ $info['p_pdf_url'] }}</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="p_flg" id="p_flg" @if ($info['p_flg']==1) checked @endif value="1">
                                        <label for="p_flg" class="custom-control-label">PDFをダウンロードする際に確認を行う</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">製品動画URL<code> Youtubeの動画URLのみ</code></label>
                                    <input type="text" value="{{ $info['p_video_url'] }}" class="form-control" id="p_video_url" name="p_video_url" placeholder="製品動画URL">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">特設サイトURL<code> URLのみ</code></label>
                                    <input type="text" value="{{ $info['p_special_weburl'] }}" class="form-control" id="p_special_weburl" name="p_special_weburl" placeholder="特設サイトURL">
                                </div>

{{--                                <div class="form-group">--}}
{{--                                    <label for="exampleInputEmail1">順番Number</label>--}}
{{--                                    <input type="number" value="{{ $info['b_sort'] }}" class="form-control" id="b_sort" name="b_sort" placeholder="順番Number">--}}
{{--                                </div>--}}

                                <div class="form-group">
                                    <label>タグ</label>
                                    <select class="select2" id="p_lables" name="p_lables[]" multiple="multiple" data-placeholder="選択してください" style="width: 100%;">
                                        @if (isset($S_PRODUCT_LABLES))
                                            @foreach($S_PRODUCT_LABLES as $val)
                                                <option value="{{$val['id']}}">{{$val['pr_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">説明<code> 必須</code></label>
                                    <div class="editor-container" style="width: 100%">
                                        <textarea class="form-control" rows="6" id="p_contents" name="p_contents" placeholder="製品説明">{{$info['p_contents']}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="p_open_flg" id="p_open_flg" @if ($info['p_open_flg'] == 1) checked @endif value="1">
                                        <label for="p_open_flg" class="custom-control-label">公開フラグ<code> 必須</code></label>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <input type="hidden" value="{{ $info['id'] }}" name="id" id="id">
                                <a href="/goods/goods_lists" class="btn btn-secondary">戻る</a>
                                <button type="button" id="submit_btn" class="btn btn-success float-right">
                                    更新
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
            var PRODUCT_LABLES_ARR = @json($PRODUCT_LABLES_ARR);
            $('#p_lables').val(PRODUCT_LABLES_ARR).trigger('change');
        });
    </script>
    <script>
        layui.use('upload', function(){
            var $ = layui.jquery
                ,upload = layui.upload;
            var url = '/api/upload/pushFIle';
            var u_flg = 0;
            //普通图片上传
            var uploadInst = upload.render({
                elem: '#upload_p_logo'
                ,url: url
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#p_logo_img').attr('src', result); //图片链接（base64）
                        var img = document.getElementById("p_logo_img");
                        img.style.display="block";
                    });
                }
                ,done: function(res){
                    if(res.STATUS == 0){
                        $("#upload_p_logo").html(res.SRC);
                        $('#p_logo').val(res.SRC); //图片链接（base64）
                        return layer.msg('アップロード成功');
                    }else {
                        return layer.msg('アップロード失敗');
                    }
                }
            });
            //普通图片上传
            var uploadInst = upload.render({
                elem: '#upload_p_main_img'
                ,url: url
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#p_main_img_img').attr('src', result); //图片链接（base64）
                        var img = document.getElementById("p_main_img_img");
                        img.style.display="block";
                    });
                }
                ,done: function(res){
                    if(res.STATUS == 0){
                        $("#upload_p_main_img").html(res.SRC);
                        $('#p_main_img').val(res.SRC); //图片链接（base64）
                        return layer.msg('アップロード成功');
                    }else {
                        return layer.msg('アップロード失敗');
                    }
                }
            });
            //上传文件
            upload.render({
                elem: '#upload_p_pdf_url'
                ,url: url
                ,field:"file"
                ,data:{"dir":"media"}
                ,accept: 'file',
                before: function(obj){
                    obj.preview(function(index, file, result){
                        if(file.type !== 'application/pdf') {
                            layer.msg('アップロードできるのはPDFファイルのみです！');
                            u_flg = 1;
                            return false;
                        }else {
                            u_flg = 0;
                        }
                    });
                },
                done: function(res){
                    if(res.STATUS == 0 && u_flg == 0){
                        $("#p_pdf_url").val(res.SRC);
                        $("#upload_p_pdf_url").html(res.SRC);
                        return layer.msg('アップロード成功');
                    }
                },
                error: function(){
                    return layer.msg('アップロード失敗');
                }
            });
        });
        function clear_p_pdf_url() {
            $("#p_pdf_url").val("");
            $("#upload_p_pdf_url").html("");
        }
    </script>

    <script>
        $(function() {
            $('#p_logo_img').click(function(){
                var imgs = this;
                var imgSrc=$(imgs).attr("src");
                $(".img_p_logo img").attr("src",imgSrc);
                $(".img_p_logo").css("display","-webkit-box");
            });

            $(".img_p_logo").click(function(){
                var box = this;
                $(box).find("img").attr("src","");
                $(box).hide();
            });

            $('#p_main_img_img').click(function(){
                var imgs = this;
                var imgSrc=$(imgs).attr("src");
                $(".img_p_main_img img").attr("src",imgSrc);
                $(".img_p_main_img").css("display","-webkit-box");
            });

            $(".img_p_main_img").click(function(){
                var box = this;
                $(box).find("img").attr("src","");
                $(box).hide();
            });

            $('#submit_btn').click(function() {
                var errors_text = "";
                if ($('#p_name').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・製品名を入力してください。";
                }
                if ($('#p_logo').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・ロゴ画像を入力してください。";
                }
                if ($('#p_main_img').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・メインイメージを入力してください。";
                }
                // if ($('#p_pdf_url').val() == "") {
                //     errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "製品カタログ（PDF）を選択してください。";
                // }
                // if ($('#p_video_url').val() == "") {
                //     errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "製品動画URLを入力してください。";
                // }
                if ($('#p_video_url').val() != "" && !isValidHttpUrl($('#p_video_url').val())) {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・製品動画URLは正しいURLを入力してください。";
                }
                // if ($('#p_special_weburl').val() == "") {
                //     errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "特設サイトURLを入力してください。";
                // }
                if ($('#p_special_weburl').val() != "" && !isValidHttpUrl($('#p_special_weburl').val())) {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・特設サイトURLは正しいURLを入力してください。";
                }
                // if ($('#p_lables').val() == "") {
                //     errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "タグを入力してください。";
                // }
                if ($('#p_contents').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・説明を入力してください。";
                }

                if (strlen(errors_text) > 0) {
                    // $.alert({
                    //     title: false,
                    //     theme: 'white',
                    //     content: errors_text,
                    //     confirmButton: 'はい',
                    //     confirmButtonClass: 'btn-info',
                    // });
                    var divContent = "<div class='card-body'><div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <h5 style='margin-bottom: 0rem;'><i class='icon fas fa-ban'></i>入力情報が正しくありません。<br><span style='font-size: 15px;'>"+errors_text+"</span></h5> </div> </div>";
                    $('#targetArea').html(divContent);
                    $('html, body').animate({scrollTop: 0}, 'slow');
                    return false;
                }

                var confirm_text = '更新してよろしいですか？';

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
