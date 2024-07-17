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
                        <h1>セミナー展示会情報</h1>
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
                        <form enctype="multipart/form-data" action="/seminar/exhibition_edit" method="post" id="form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">タイトル	</label>
                                    <input type="text" value="{{ $info['title'] }}" class="form-control" id="title" name="title" placeholder="タイトル">
                                </div>

                                <div class="form-group">
                                    <label>カテゴリ</label>
                                    <select class="form-control select2" name="category" id="category" style="width: 100%;">
                                        <option @if ($info['category']==1) selected @endif value="1">セミナー</option>
                                        <option @if ($info['category']==2) selected @endif value="2">展示会</option>
                                    </select>
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
                                    <label for="exampleInputEmail1">申込URL</label>
                                    <input type="text" value="{{ $info['apply_url'] }}" class="form-control" id="apply_url" name="apply_url" placeholder="申込URL">
                                </div>

                                <div class="form-group">
                                    <label>公開フラグ</label>
                                    <select class="form-control select2" name="open_flg" id="open_flg" style="width: 100%;">
                                        <option @if ($info['open_flg']==0) selected @endif value="0">公開</option>
                                        <option @if ($info['open_flg']==1) selected @endif value="1">未公開</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>タグ</label>
                                    <select class="select2" id="c_lables" name="c_lables[]" multiple="multiple" data-placeholder="選択してください" style="width: 100%;">
                                        @if (isset($S_SEMINARS_EXHIBITIONS_LABLES))
                                            @foreach($S_SEMINARS_EXHIBITIONS_LABLES as $val)
                                                <option value="{{$val['id']}}">{{$val['s_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>開催日1</label>
                                    <div class="input-group date" id="start_date1" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#start_date1" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" value="{{ empty($info['exhibition_dates1']) ? '' : $info['exhibition_dates1'] }}" readonly name="exhibition_dates1" id="exhibition_dates1" class="form-control datetimepicker-input" data-target="#start_date1"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>開催日2</label>
                                    <div class="input-group date" id="start_date2" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#start_date2" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" value="{{ empty($info['exhibition_dates2']) ? '' : $info['exhibition_dates2'] }}" readonly name="exhibition_dates2" id="exhibition_dates2" class="form-control datetimepicker-input" data-target="#start_date2"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>開催日3</label>
                                    <div class="input-group date" id="start_date3" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#start_date3" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" value="{{ empty($info['exhibition_dates3']) ? '' : $info['exhibition_dates3'] }}" readonly name="exhibition_dates3" id="exhibition_dates3" class="form-control datetimepicker-input" data-target="#start_date3"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>開催日4</label>
                                    <div class="input-group date" id="start_date4" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#start_date4" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" value="{{ empty($info['exhibition_dates4']) ? '' : $info['exhibition_dates4'] }}" readonly name="exhibition_dates4" id="exhibition_dates4" class="form-control datetimepicker-input" data-target="#start_date4"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>開催日5</label>
                                    <div class="input-group date" id="start_date5" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#start_date5" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" value="{{ empty($info['exhibition_dates5']) ? '' : $info['exhibition_dates5'] }}" readonly name="exhibition_dates5" id="exhibition_dates5" class="form-control datetimepicker-input" data-target="#start_date5"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>開催日6</label>
                                    <div class="input-group date" id="start_date6" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#start_date6" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" value="{{ empty($info['exhibition_dates6']) ? '' : $info['exhibition_dates6'] }}" readonly name="exhibition_dates6" id="exhibition_dates6" class="form-control datetimepicker-input" data-target="#start_date6"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>開催時間</label>
                                    <div class="input-group date" id="start_date_time" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#start_date_time" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" readonly value="{{ $info['opening_times'] }}" name="opening_times" id="opening_times" class="form-control datetimepicker-input" data-target="#start_date_time"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">開催場所</label>
                                    <input type="text" value="{{ $info['address_info'] }}" class="form-control" id="address_info" name="address_info" placeholder="開催場所">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">説明</label>
                                    <div class="editor-container" style="width: 100%">
                                        <textarea class="form-control" id="p_contents" name="p_contents" placeholder="説明">{{$info['p_contents']}}</textarea>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <input type="hidden" value="{{ $info['id'] }}" name="id" id="id">
                                <a href="/seminar/exhibition_lists" class="btn btn-secondary">戻る</a>
                                <button type="button" id="submit_btn" class="btn btn-success float-right">
                                    変更
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
        $(function () {
            $('.select2').select2();
            var S_SEMINARS_EXHIBITIONS_LABLES_ARR = @json($S_SEMINARS_EXHIBITIONS_LABLES_ARR);
            $('#c_lables').val(S_SEMINARS_EXHIBITIONS_LABLES_ARR).trigger('change');

            //Date picker
            $('#start_date1').datetimepicker({
                format: 'YYYY-MM-DD',
                locale: 'ja',
            });
            $('#start_date2').datetimepicker({
                format: 'YYYY-MM-DD',
                locale: 'ja',
            });
            $('#start_date3').datetimepicker({
                format: 'YYYY-MM-DD',
                locale: 'ja',
            });
            $('#start_date4').datetimepicker({
                format: 'YYYY-MM-DD',
                locale: 'ja',
            });
            $('#start_date5').datetimepicker({
                format: 'YYYY-MM-DD',
                locale: 'ja',
            });
            $('#start_date6').datetimepicker({
                format: 'YYYY-MM-DD',
                locale: 'ja',
            });

            $('#start_date_time').datetimepicker({
                format: 'HH:mm',
                locale: 'ja'
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
                if ($('#title').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "タイトルを入力してください。";
                }
                if ($('#category').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "カテゴリを入力してください。";
                }
                if ($('#apply_url').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "申込URLを入力してください。";
                }
                if ($('#b_url').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "バナー画像を入力してください。";
                }
                if ($('#exhibition_dates').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "開催日を入力してください。";
                }
                if ($('#opening_times').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "開催時間を入力してください。";
                }
                if ($('#p_contents').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "説明を入力してください。";
                }
                if ($('#c_lables').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "タグを入力してください。";
                }
                if ($('#address_info').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "開催場所を入力してください。";
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

                var confirm_text = '変更してよろしいですか？';

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
