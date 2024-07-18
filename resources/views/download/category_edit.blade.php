@extends('main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>カテゴリ情報</h1>
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
                        <form enctype="multipart/form-data" action="/download/category_edit" method="post" id="form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">カテゴリ名</label>
                                    <input type="text" value="{{ $info['category_name'] }}" class="form-control" id="category_name" name="category_name" placeholder="カテゴリ名">
                                </div>

                                <div class="form-group">
                                    <label>公開フラグ</label>
                                    <select class="form-control select2" name="open_flg" id="open_flg" style="width: 100%;">
                                        <option @if ($info['open_flg']==0) selected @endif value="0">未公開</option>
                                        <option @if ($info['open_flg']==1) selected @endif value="1">公開</option>
                                    </select>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <input type="hidden" value="{{ $info['id'] }}" name="id" id="id">
                                <a href="/download/category_lists" class="btn btn-secondary">戻る</a>
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
        });
    </script>
    <script>
        $(function() {
            $('#submit_btn').click(function() {
                var errors_text = "";
                if ($('#category_name').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "カテゴリ名を入力してください。";
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
