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
                        <h1>講師情報</h1>
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
                        <form enctype="multipart/form-data" action="/seminar/teacher_edit" method="post" id="form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">名前</label>
                                    <input type="text" value="{{$info['l_name']}}" class="form-control" id="l_name" name="l_name" placeholder="名前">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputFile">バナー画像</label>
                                    <div class="custom-file">
                                        <input type="hidden" value="{{ $info['b_url'] }}" name="b_url" id="b_url" class="custom-file-input">
                                        <label class="custom-file-label" for="customFile" id="upload_b_url">{{ $info['b_url'] }}</label>
                                    </div>
                                    <img src="{{ $info['b_url'] }}" class="layui-upload-img" style="width:100px;height:100px;margin-top: 1%" id="b_url_img" name="b_url_img">
                                </div>
                                <div class="img_b_url"><img src="" alt=""></div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">専門分野</label>
                                    <input type="text" value="{{$info['l_professions']}}" class="form-control" id="l_professions" name="l_professions" placeholder="専門分野">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">経歴・資格</label>
                                    <input type="text" value="{{$info['l_career_qualifications']}}" class="form-control" id="l_career_qualifications" name="l_career_qualifications" placeholder="経歴・資格">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">セミナー実績</label>
                                    <input type="text" value="{{$info['l_seminar_results']}}" class="form-control" id="l_seminar_results" name="l_seminar_results" placeholder="セミナー実績">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">エリア</label>
                                    <input type="text" value="{{$info['l_area']}}" class="form-control" id="l_area" name="l_area" placeholder="エリア">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">フリーテキスト</label>
                                    <div class="editor-container" style="width: 100%">
                                        <textarea class="form-control" rows="6" id="l_contents" name="l_contents" placeholder="フリーテキスト">{{$info['l_contents']}}</textarea>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <input type="hidden" value="{{ $info['id'] }}" name="id" id="id">
                                <a href="/seminar/teacher_lists" class="btn btn-secondary">戻る</a>
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
                if ($('#l_name').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・名前を入力してください。";
                }
                if ($('#b_url').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・写真を入力してください。";
                }
                if ($('#l_professions').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・専門分野を入力してください。";
                }
                if ($('#l_career_qualifications').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・経歴・資格を入力してください。";
                }
                if ($('#l_seminar_results').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・セミナー実績を入力してください。";
                }
                if ($('#l_area').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・エリアを入力してください。";
                }
                if ($('#l_contents').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・フリーテキストを入力してください。";
                }

                if (strlen(errors_text) > 0) {
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
    </script>
@endsection
