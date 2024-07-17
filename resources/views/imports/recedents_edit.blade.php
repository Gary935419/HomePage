@extends('main')
@section('content')
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
                                    <label for="exampleInputEmail1">タイトル</label>
                                    <input type="text" value="{{ $info['pr_title'] }}" class="form-control" id="pr_title" name="pr_title" placeholder="タイトル">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputFile">サムネイル画像</label>
                                    <div class="custom-file">
                                        <input type="hidden" value="{{ $info['pr_img_url'] }}" name="pr_img_url" id="pr_img_url" class="custom-file-input">
                                        <label class="custom-file-label" for="customFile" id="upload_pr_img_url">{{ $info['pr_img_url'] }}</label>
                                    </div>
                                    <img src="{{ $info['pr_img_url'] }}" class="layui-upload-img" style="width:100px;height:100px;margin-top: 1%" id="pr_img_url_img" name="pr_img_url_img">
                                </div>
                                <div class="img_pr_img_url"><img src="" alt=""></div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">会社名</label>
                                    <input type="text" value="{{ $info['guild_name'] }}" class="form-control" id="guild_name" name="guild_name" placeholder="会社名">
                                </div>

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
                                    <label for="exampleInputEmail1">記事</label>
                                    <div class="editor-container" style="width: 100%">
                                        <textarea class="editor" id="pr_contents" name="pr_contents">
                                            {{$info['pr_contents']}}
                                        </textarea>
                                    </div>
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
    <script>
        ClassicEditor
            .create( document.querySelector( '.editor' ), {
                ckbox: {
                    tokenUrl: "https://111143.cke-cs.com/token/dev/LzRR1kAjFfQJowpfgdfgjf7WrmUgcsSM6pQZ?limit=10"
                }
            } )
            .then( editor => {
                window.editor = editor;
            } )
            .catch( handleSampleError );

        function handleSampleError( error ) {
            const issueUrl = 'https://github.com/ckeditor/ckeditor5/issues';

            const message = [
                'Oops, something went wrong!',
                `Please, report the following error on ${ issueUrl } with the build id "8dm8znofk5cn-o9aoctpccx4l" and the error stack trace:`
            ].join( '\n' );

            console.error( message );
            console.error( error );
        }
    </script>
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
            //普通图片上传
            var uploadInst = upload.render({
                elem: '#upload_pr_img_url'
                ,url: url
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#pr_img_url_img').attr('src', result); //图片链接（base64）
                        var img = document.getElementById("pr_img_url_img");
                        img.style.display="block";
                    });
                }
                ,done: function(res){
                    if(res.STATUS == 0){
                        $("#upload_pr_img_url").html(res.SRC);
                        $('#pr_img_url').val(res.SRC); //图片链接（base64）
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


            $('#submit_btn').click(function() {
                var errors_text = "";
                if ($('#pr_title').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "タイトルを入力してください。";
                }
                if ($('#pr_img_url').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "サムネイル画像を入力してください。";
                }
                if ($('#guild_name').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "会社名を入力してください。";
                }
                if ($('#pr_labels').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "タグを入力してください。";
                }
                if ($('#pr_contents').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "記事を入力してください。";
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
