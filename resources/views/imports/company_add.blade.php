@extends('main')
@section('content')
    <style>
        .img_logo_url {
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
        .img_logo_url img {
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
                        <h1>企業情報</h1>
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
                        <form enctype="multipart/form-data" action="/imports/company_regist" method="post" id="form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">企業名</label>
                                    <input type="text" class="form-control" id="c_name" name="c_name" placeholder="企業名">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">企業名フリガナ</label>
                                    <input type="text" class="form-control" id="furigana_name" name="furigana_name" placeholder="企業名フリガナ">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputFile">ロゴ</label>
                                    <div class="custom-file">
                                        <input type="hidden" name="logo_url" id="logo_url" class="custom-file-input">
                                        <label class="custom-file-label" for="customFile" id="upload_logo_url">ファイルを選択</label>
                                    </div>
                                    <img class="layui-upload-img" style="width:100px;height:100px;display: none;margin-top: 1%" id="logo_url_img">
                                </div>
                                <div class="img_logo_url"><img src="" alt=""></div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">導入事例URL</label>
                                    <input type="text" class="form-control" id="precedents_url" name="precedents_url" placeholder="導入事例URL">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">紹介動画URL	</label>
                                    <input type="text" class="form-control" id="video_url" name="video_url" placeholder="紹介動画URL	">
                                </div>

                                <div class="form-group">
                                    <label>タグ</label>
                                    <select class="select2" id="c_lables" name="c_lables[]" multiple="multiple" data-placeholder="選択してください" style="width: 100%;">
                                        @if (isset($S_PRODECT_LABLES))
                                            @foreach($S_PRODECT_LABLES as $val)
                                                <option value="{{$val['id']}}">{{$val['p_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>選抜フラグ</label>
                                    <select class="form-control select2" name="select_flg" id="select_flg" style="width: 100%;">
                                        <option selected="selected" value="0">未確認</option>
                                        <option value="1">確認完了</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>公開フラグ</label>
                                    <select class="form-control select2" name="open_flg" id="open_flg" style="width: 100%;">
                                        <option selected="selected" value="0">未公開</option>
                                        <option value="1">公開</option>
                                    </select>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="/imports/recedents_lists" class="btn btn-secondary">戻る</a>
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
            //普通图片上传
            var uploadInst = upload.render({
                elem: '#upload_logo_url'
                ,url: url
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#logo_url_img').attr('src', result); //图片链接（base64）
                        var img = document.getElementById("logo_url_img");
                        img.style.display="block";
                    });
                }
                ,done: function(res){
                    if(res.STATUS == 0){
                        $("#upload_logo_url").html(res.SRC);
                        $('#logo_url').val(res.SRC); //图片链接（base64）
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
            $('#logo_url_img').click(function(){
                var imgs = this;
                var imgSrc=$(imgs).attr("src");
                $(".img_logo_url img").attr("src",imgSrc);
                $(".img_logo_url").css("display","-webkit-box");
            });

            $(".img_logo_url").click(function(){
                var box = this;
                $(box).find("img").attr("src","");
                $(box).hide();
            });

            $('#submit_btn').click(function() {
                var errors_text = "";
                if ($('#c_name').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "企業名を入力してください。";
                }
                if ($('#furigana_name').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "企業名フリガナ	を入力してください。";
                }
                if ($('#logo_url').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "ロゴを入力してください。";
                }
                if ($('#precedents_url').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "導入事例URLを入力してください。";
                }
                if ($('#c_lables').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "タグを入力してください。";
                }
                if ($('#video_url').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "紹介動画URL	を入力してください。";
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
