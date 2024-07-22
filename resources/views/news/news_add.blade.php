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
                        <form enctype="multipart/form-data" action="/news/news_regist" method="post" id="form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">タイトル	</label>
                                    <input type="text" class="form-control" id="n_title" name="n_title" placeholder="タイトル">
                                </div>

                                <div class="form-group">
                                    <label>カテゴリ</label>
                                    <select class="form-control select2" name="n_type" id="n_type" style="width: 100%;">
                                        <option value="0">選択してください</option>
                                        <option value="1">新着情報</option>
                                        <option value="2">セミナー展示会</option>
                                        <option value="3">ニュースリリース</option>
                                        <option value="4">メディア</option>
                                        <option value="4">障害連絡</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">本文</label>
                                    <div class="editor-container" style="width: 100%">
                                        <textarea class="editor" id="n_contents" name="n_contents">

                                        </textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="n_important_flg" id="n_important_flg" value="1">
                                        <label for="n_important_flg" class="custom-control-label">重要なお知らせフラグ</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="n_open_flg" id="n_open_flg" value="1">
                                        <label for="n_open_flg" class="custom-control-label">公開フラグ</label>
                                    </div>
                                </div>

                                <div class="form-group" id="n_open_date_see" style="display: none">
                                    <label>公開日時</label>
                                    <div class="input-group date" id="start_date" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" readonly name="n_open_date" id="n_open_date" class="form-control datetimepicker-input" data-target="#start_date"/>
                                    </div>
                                </div>

                                <div class="form-group" id="n_close_date_see" style="display: none">
                                    <label>終了日時</label>
                                    <div class="input-group date" id="end_date" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#end_date" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" readonly name="n_close_date" id="n_close_date" class="form-control datetimepicker-input" data-target="#end_date"/>
                                    </div>
                                </div>

                                <div class="form-group" id="n_fixed_flg_see" style="display: none">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="n_fixed_flg" id="n_fixed_flg" value="1">
                                        <label for="n_fixed_flg" class="custom-control-label">固定フラグ</label>
                                    </div>
                                </div>

                                <div class="form-group" id="fix_open_date_see" style="display: none">
                                    <label>固定公開日時</label>
                                    <div class="input-group date" id="fix_start_date" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#fix_start_date" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" readonly name="fix_open_date" id="fix_open_date" class="form-control datetimepicker-input" data-target="#fix_start_date"/>
                                    </div>
                                </div>

                                <div class="form-group" id="fix_close_date_see" style="display: none">
                                    <label>固定終了日時</label>
                                    <div class="input-group date" id="fix_end_date" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#fix_end_date" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" readonly name="fix_close_date" id="fix_close_date" class="form-control datetimepicker-input" data-target="#fix_end_date"/>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="/news/news_lists" class="btn btn-secondary">戻る</a>
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
        ClassicEditor
            .create( document.querySelector( '.editor' ), {
                ckbox: {
                    tokenUrl: "https://111143.cke-cs.com/token/dev/LzRR1kAjFfQJowpfgdfgjf7WrmUgcsSM6pQZ?limit=10"
                }
            } )
            .then(editor => {
                // 设置编辑器容器的高度
                editor.ui.view.editable.element.style.height = '500px';
                // 确保高度在每次聚焦时保持一致
                editor.ui.view.editable.element.addEventListener('focus', () => {
                    editor.ui.view.editable.element.style.height = '500px';
                });
                // 确保高度在每次输入时保持一致
                editor.model.document.on('change:data', () => {
                    editor.ui.view.editable.element.style.height = '500px';
                });
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        $(function () {
            $('.select2').select2()

            $('#start_date').datetimepicker({
                format: 'YYYY-MM-DD HH:mm',
                locale: 'ja',
                icons: {
                    time: 'far fa-clock'
                }
            });

            $('#end_date').datetimepicker({
                format: 'YYYY-MM-DD HH:mm',
                locale: 'ja',
                icons: {
                    time: 'far fa-clock'
                }
            });

            $('#start_date input').focus(function() {
                $('#start_date').data("datetimepicker").show();
            });

            $('#end_date input').focus(function() {
                $('#end_date').data("datetimepicker").show();
            });

            $('#fix_start_date').datetimepicker({
                format: 'YYYY-MM-DD HH:mm',
                locale: 'ja',
                icons: {
                    time: 'far fa-clock'
                }
            });

            $('#fix_end_date').datetimepicker({
                format: 'YYYY-MM-DD HH:mm',
                locale: 'ja',
                icons: {
                    time: 'far fa-clock'
                }
            });

            $('#fix_start_date input').focus(function() {
                $('#fix_start_date').data("datetimepicker").show();
            });

            $('#fix_end_date input').focus(function() {
                $('#fix_end_date').data("datetimepicker").show();
            });
        });
    </script>

    <script>
        $(function() {
            $('#submit_btn').click(function() {
                var errors_text = "";
                if ($('#n_title').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・タイトルを入力してください。";
                }
                if ($('#n_type').val() == 0) {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・カテゴリを入力してください。";
                }
                // if ($('#n_open_date').val() == "") {
                //     errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "・公開日時を入力してください。";
                // }

                if (strlen(errors_text) > 0) {
                    var divContent = "<div class='card-body'><div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <h5 style='margin-bottom: 0rem;'><i class='icon fas fa-ban'></i>入力情報が正しくありません。<br><span style='font-size: 15px;'>"+errors_text+"</span></h5> </div> </div>";
                    $('#targetArea').html(divContent);
                    $('html, body').animate({scrollTop: 0}, 'slow');
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
    <script>
        $(document).ready(function() {
            $('#n_open_flg').click(function() {
                var isChecked = $(this).is(':checked');
                var value = $(this).val();
                if (isChecked) {
                    $("#n_open_date_see").show();
                    $("#n_close_date_see").show();
                    $("#n_fixed_flg_see").show();
                } else {
                    $("#n_open_date_see").hide();
                    $("#n_close_date_see").hide();
                    $("#n_fixed_flg_see").hide();
                    $("#n_open_date").val("");
                    $("#n_close_date").val("");
                    $('#n_fixed_flg').prop('checked', false);
                    $("#fix_open_date_see").hide();
                    $("#fix_close_date_see").hide();
                    $("#fix_open_date").val("");
                    $("#fix_close_date").val("");
                }
            });

            $('#n_fixed_flg').click(function() {
                var isfChecked = $(this).is(':checked');
                if (isfChecked) {
                    $("#fix_open_date_see").show();
                    $("#fix_close_date_see").show();
                } else {
                    $("#fix_open_date_see").hide();
                    $("#fix_close_date_see").hide();
                    $("#fix_open_date").val("");
                    $("#fix_close_date").val("");
                }
            });
        });
    </script>
@endsection
