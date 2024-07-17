@extends('main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>ニュース情報</h1>
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
                        <form enctype="multipart/form-data" action="/news/news_edit" method="post" id="form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">タイトル	</label>
                                    <input type="text" value="{{ $info['n_title'] }}" class="form-control" id="n_title" name="n_title" placeholder="タイトル">
                                </div>

                                <div class="form-group">
                                    <label>カテゴリ</label>
                                    <select class="form-control select2" name="n_type" id="n_type" style="width: 100%;">
                                        <option @if ($info['n_type']==1) selected @endif value="1">新着情報</option>
                                        <option @if ($info['n_type']==2) selected @endif value="2">セミナー展示会</option>
                                        <option @if ($info['n_type']==3) selected @endif value="3">ニュースリリース</option>
                                        <option @if ($info['n_type']==4) selected @endif value="4">メディア</option>
                                        <option @if ($info['n_type']==5) selected @endif value="5">障害連絡</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>重要なお知らせフラグ</label>
                                    <select class="form-control select2" name="n_important_flg" id="n_important_flg" style="width: 100%;">
                                        <option @if ($info['n_important_flg']==0) selected @endif value="0">そうです</option>
                                        <option @if ($info['n_important_flg']==1) selected @endif value="1">違います</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>公開フラグ</label>
                                    <select class="form-control select2" name="n_open_flg" id="n_open_flg" style="width: 100%;">
                                        <option @if ($info['n_open_flg']==0) selected @endif value="0">公開</option>
                                        <option @if ($info['n_open_flg']==1) selected @endif value="1">未公開</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>固定フラグ</label>
                                    <select class="form-control select2" name="n_fixed_flg" id="n_fixed_flg" style="width: 100%;">
                                        <option @if ($info['n_fixed_flg']==0) selected @endif value="0">未固定</option>
                                        <option @if ($info['n_fixed_flg']==1) selected @endif value="1">固定</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>公開日時</label>
                                    <div class="input-group date" id="start_date" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" value="{{ $info['n_open_date'] }}" name="n_open_date" id="n_open_date" class="form-control datetimepicker-input" data-target="#start_date"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>終了日時</label>
                                    <div class="input-group date" id="end_date" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#end_date" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" value="{{ $info['n_close_date'] }}" name="n_close_date" id="n_close_date" class="form-control datetimepicker-input" data-target="#end_date"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">本文</label>
                                    <div class="editor-container" style="width: 100%">
                                        <textarea class="editor" id="n_contents" name="n_contents">
                                            {{$info['n_contents']}}
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <input type="hidden" value="{{ $info['id'] }}" name="id" id="id">
                                <a href="/news/news_lists" class="btn btn-secondary">戻る</a>
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
            $('.select2').select2()

            //Date picker//Date picker
            $('#start_date').datetimepicker({
                format: 'YYYY-MM-DD',
                locale: 'ja'
            });

            $('#end_date').datetimepicker({
                format: 'YYYY-MM-DD',
                locale: 'ja'
            });
        });
    </script>

    <script>
        $(function() {

            $('#submit_btn').click(function() {
                var errors_text = "";
                if ($('#n_title').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "タイトルを入力してください。";
                }
                if ($('#n_type').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "カテゴリを入力してください。";
                }
                if ($('#n_open_date').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "公開日時を入力してください。";
                }
                if ($('#n_close_date').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "終了日時を入力してください。";
                }
                if ($('#n_contents').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "本文を入力してください。";
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
