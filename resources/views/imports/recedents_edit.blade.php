@extends('main')
@section('content')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.2/ckeditor5.css">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5-premium-features/42.0.2/ckeditor5-premium-features.css">
    <style>
        .img_pr_img_url {
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
        .img_pr_img_url img {
            cursor: zoom-out;
        }
        .img_guild_logo {
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
        .img_guild_logo img {
            cursor: zoom-out;
        }
        .img_main_img_url {
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
        .img_main_img_url img {
            cursor: zoom-out;
        }
        .fuki {
            display: inline-block;
            background: #004894;
            color: #fff;
            padding: 10px 40px;
            line-height: 1.4;
            text-align: center;
            border-radius: 100px;
            font-weight: 700;
            font-size: 120%;
            position: relative;
            margin-bottom: 20px;
            margin-top: 80px;
        }
        .customers_detail_section_ttl {
            font-size: 150%;
            line-height: 1.4;
            color: #004894;
            border-bottom: 1px solid #004894;
            padding-bottom: 20px;
            margin-bottom: 20px;
            font-weight: 500;
        }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>事例情報</h1>
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
                        <form enctype="multipart/form-data" action="/imports/recedents_edit" method="post" id="form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">タイトル<code>.必須</code></label>
                                    <input type="text" value="{{ $info['pr_title'] }}" class="form-control" id="pr_title" name="pr_title" placeholder="タイトル">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputFile">サムネイル画像<code>.必須、推奨サイズ（400px X 400px）</code></label>
                                    <div class="custom-file">
                                        <input type="hidden" value="{{ $info['pr_img_url'] }}" name="pr_img_url" id="pr_img_url" class="custom-file-input">
                                        <label class="custom-file-label" for="customFile" id="upload_pr_img_url">{{ $info['pr_img_url'] }}</label>
                                    </div>
                                    <img src="{{ $info['pr_img_url'] }}" class="layui-upload-img" style="width:100px;height:100px;margin-top: 1%" id="pr_img_url_img" name="pr_img_url_img">
                                </div>
                                <div class="img_pr_img_url"><img src="" alt=""></div>

                                <div class="form-group">
                                    <label>タグ</label>
                                    <select class="select2" id="pr_labels" name="pr_labels[]" multiple="multiple" data-placeholder="選択してください" style="width: 100%;">
                                        @if (isset($S_PRODECT_LABLES))
                                            @foreach($S_PRODECT_LABLES as $val)
                                                <option value="{{$val['id']}}">{{$val['p_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">会社名<code>.必須</code></label>
                                    <input type="text" value="{{ $info['guild_name'] }}" class="form-control" id="guild_name" name="guild_name" placeholder="会社名">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputFile">会社ロゴ<code>.必須、推奨サイズ（400px X 400px）</code></label>
                                    <div class="custom-file">
                                        <input type="hidden" value="{{ $info['guild_logo'] }}" name="guild_logo" id="guild_logo" class="custom-file-input">
                                        <label class="custom-file-label" for="customFile" id="upload_guild_logo">{{ $info['guild_logo'] }}</label>
                                    </div>
                                    <img src="{{ $info['guild_logo'] }}" class="layui-upload-img" style="width:100px;height:100px;margin-top: 1%" id="guild_logo_img" name="guild_logo_img">
                                </div>
                                <div class="img_guild_logo"><img src="" alt=""></div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">会社説明<code>.必須</code></label>
                                    <div class="editor-container" style="width: 100%">
                                        <textarea class="form-control" rows="6" id="guild_descriptions" name="guild_descriptions" placeholder="会社説明">{{ $info['guild_descriptions'] }}</textarea>
                                    </div>
                                </div>

{{--                                <div class="form-group">--}}
{{--                                    <label for="exampleInputEmail1">記事</label>--}}
{{--                                    <div class="editor-container" style="width: 100%">--}}
{{--                                        <textarea class="editor" id="pr_contents" rows="5" name="pr_contents">--}}
{{--                                            {{$info['pr_contents']}}--}}
{{--                                        </textarea>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">記事<code>.必須</code></label>
                                    <div class="editor-container">
                                        <textarea class="editor" id="editor" name="pr_contents">
                                            {{$info['pr_contents']}}
                                        </textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputName">メインフラグ<code>.必須、画像のアップか動画URLを選択してください</code></label><br>
                                    <div class="icheck-primary d-inline">
                                        <input type="radio" onclick="return dispaly_update(0)" id="radioPrimary1" @if ($info['main_flg'] == 0) checked @endif name="main_flg" value="0">
                                        <label for="radioPrimary1">
                                            画像
                                        </label>
                                    </div>
                                    <div class="icheck-primary d-inline" style="margin-left: 2%">
                                        <input type="radio" onclick="return dispaly_update(1)" id="radioPrimary2" @if ($info['main_flg'] == 1) checked @endif name="main_flg" value="1">
                                        <label for="radioPrimary2">
                                            動画
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group" id="main_img" style="display: @if ($info['main_flg'] == 0) block @else none @endif">
                                    <label for="exampleInputFile">メインイメージ<code>.必須、推奨サイズ（800px X 480px）</code></label>
                                    <div class="custom-file">
                                        <input type="hidden" value="{{ $info['main_img_url'] }}" name="main_img_url" id="main_img_url" class="custom-file-input">
                                        <label class="custom-file-label" for="customFile" id="upload_main_img_url">{{ $info['main_img_url'] }}</label>
                                    </div>
                                    <img src="{{ $info['main_img_url'] }}" class="layui-upload-img" style="width:100px;height:100px;display: none;margin-top: 1%" id="main_img_url_img" name="main_img_url_img">
                                </div>
                                <div class="img_main_img_url"><img src="" alt=""></div>

                                <div class="form-group" id="main_video" style="display: @if ($info['main_flg'] == 1) block @else none @endif">
                                    <label for="exampleInputEmail1">メイン動画URL<code>.必須、Youtubeの動画URLのみ</code></label>
                                    <input type="text" class="form-control" value="{{ $info['main_video_url'] }}" id="main_video_url" name="main_video_url" placeholder="メイン動画URL">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <input type="hidden" value="{{ $info['id'] }}" name="id" id="id">
                                <a href="/imports/recedents_lists" class="btn btn-secondary">戻る</a>
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
    <script type="importmap">
        {
            "imports": {
                "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.2/ckeditor5.js",
                "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.2/",
                "ckeditor5-premium-features": "https://cdn.ckeditor.com/ckeditor5-premium-features/42.0.2/ckeditor5-premium-features.js",
                "ckeditor5-premium-features/": "https://cdn.ckeditor.com/ckeditor5-premium-features/42.0.2/"
            }
        }
    </script>
{{--    <script src="https://cdn.ckbox.io/ckbox/latest/ckbox.js"></script>--}}
    <script type="module" src="{{ asset('assets/ckeditor/main.js') }}"></script>
{{--    <script>--}}
{{--        ClassicEditor--}}
{{--            .create( document.querySelector( '.editor' ), {--}}
{{--                ckbox: {--}}
{{--                    tokenUrl: "https://111143.cke-cs.com/token/dev/LzRR1kAjFfQJowpfgdfgjf7WrmUgcsSM6pQZ?limit=10"--}}
{{--                }--}}
{{--            } )--}}
{{--            .then(editor => {--}}
{{--                // 设置编辑器容器的高度--}}
{{--                editor.ui.view.editable.element.style.height = '500px';--}}
{{--                // 确保高度在每次聚焦时保持一致--}}
{{--                editor.ui.view.editable.element.addEventListener('focus', () => {--}}
{{--                    editor.ui.view.editable.element.style.height = '500px';--}}
{{--                });--}}
{{--                // 确保高度在每次输入时保持一致--}}
{{--                editor.model.document.on('change:data', () => {--}}
{{--                    editor.ui.view.editable.element.style.height = '500px';--}}
{{--                });--}}
{{--            })--}}
{{--            .catch(error => {--}}
{{--                console.error(error);--}}
{{--            });--}}
{{--    </script>--}}
    <script>
        $(function () {
            $('.select2').select2();
            var PRODECT_LABLES_ARR = @json($PRODECT_LABLES_ARR);
            $('#pr_labels').val(PRODECT_LABLES_ARR).trigger('change');
        });
    </script>
    <script>
        layui.use('upload', function(){
            var $ = layui.jquery
                ,upload = layui.upload;
            var url = '/api/upload/pushFIle';
            upload.render({
                elem: '#upload_pr_img_url'
                ,url: url
                ,before: function(obj){
                    obj.preview(function(index, file, result){
                        $('#pr_img_url_img').attr('src', result);
                        var img = document.getElementById("pr_img_url_img");
                        img.style.display="block";
                    });
                }
                ,done: function(res){
                    if(res.STATUS == 0){
                        $("#upload_pr_img_url").html(res.SRC);
                        $('#pr_img_url').val(res.SRC);
                        return layer.msg('アップロード成功');
                    }else {
                        return layer.msg('アップロード失敗');
                    }
                }
            });
            upload.render({
                elem: '#upload_guild_logo'
                ,url: url
                ,before: function(obj){
                    obj.preview(function(index, file, result){
                        $('#guild_logo_img').attr('src', result);
                        var img = document.getElementById("guild_logo_img");
                        img.style.display="block";
                    });
                }
                ,done: function(res){
                    if(res.STATUS == 0){
                        $("#upload_guild_logo").html(res.SRC);
                        $('#guild_logo').val(res.SRC);
                        return layer.msg('アップロード成功');
                    }else {
                        return layer.msg('アップロード失敗');
                    }
                }
            });
            upload.render({
                elem: '#upload_main_img_url'
                ,url: url
                ,before: function(obj){
                    obj.preview(function(index, file, result){
                        $('#main_img_url_img').attr('src', result);
                        var img = document.getElementById("main_img_url_img");
                        img.style.display="block";
                    });
                }
                ,done: function(res){
                    if(res.STATUS == 0){
                        $("#upload_main_img_url").html(res.SRC);
                        $('#main_img_url').val(res.SRC);
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
            $('#pr_img_url_img').click(function(){
                var imgs = this;
                var imgSrc=$(imgs).attr("src");
                $(".img_pr_img_url img").attr("src",imgSrc);
                $(".img_pr_img_url").css("display","-webkit-box");
            });

            $(".img_pr_img_url").click(function(){
                var box = this;
                $(box).find("img").attr("src","");
                $(box).hide();
            });

            $('#guild_logo_img').click(function(){
                var imgs = this;
                var imgSrc=$(imgs).attr("src");
                $(".img_guild_logo img").attr("src",imgSrc);
                $(".img_guild_logo").css("display","-webkit-box");
            });

            $(".img_guild_logo").click(function(){
                var box = this;
                $(box).find("img").attr("src","");
                $(box).hide();
            });

            $('#main_img_url_img').click(function(){
                var imgs = this;
                var imgSrc=$(imgs).attr("src");
                $(".img_main_img_url img").attr("src",imgSrc);
                $(".img_main_img_url").css("display","-webkit-box");
            });

            $(".img_main_img_url").click(function(){
                var box = this;
                $(box).find("img").attr("src","");
                $(box).hide();
            });

            $('#submit_btn').click(function() {
                var errors_text = "";
                if ($('#pr_title').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・タイトルを入力してください。";
                }
                if ($('#pr_img_url').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・サムネイル画像を入力してください。";
                }
                if ($('#guild_name').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・会社名を入力してください。";
                }
                if ($('#guild_logo').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・会社ロゴを入力してください。";
                }
                if ($('#guild_descriptions').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・会社説明を入力してください。";
                }
                if ($('#pr_labels').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・タグを入力してください。";
                }
                if ($("input[name='main_flg']:checked").val() == 1 && $('#main_video_url').val() != "" && !isValidHttpUrl($('#main_video_url').val())) {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・メイン動画URLは正しいURLを入力してください。";
                }
                if (strlen(errors_text) > 0) {
                    // $.alert({
                    //     title: false,
                    //     theme: 'white',
                    //     content: errors_text,
                    //     confirmButton: 'はい',
                    //     confirmButtonClass: 'btn-info',
                    // });
                    // return false;
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
        function dispaly_update(status) {
            if(status == 1){
                $("#main_img").hide();
                $("#main_video").show();
            }else {
                $("#main_img").show();
                $("#main_video").hide();
            }
        }
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
