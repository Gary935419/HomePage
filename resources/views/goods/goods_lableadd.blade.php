@extends('main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>タグ情報</h1>
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
                        <form enctype="multipart/form-data" action="/goods/goods_lableregist" method="post" id="form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">タグ名</label>
                                    <input type="text" class="form-control" id="pr_name" name="pr_name" placeholder="タグ名">
                                </div>

{{--                                <div class="form-group">--}}
{{--                                    <label for="exampleInputEmail1">順番Number</label>--}}
{{--                                    <input type="number" class="form-control" id="pr_sort" name="pr_sort" placeholder="順番Number">--}}
{{--                                </div>--}}
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <a href="/goods/goods_lablelists" class="btn btn-secondary">戻る</a>
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
        $(function() {
            $('#submit_btn').click(function() {
                var errors_text = "";
                if ($('#pr_name').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "タグ名を入力してください。";
                }
                // if ($('#pr_sort').val() == "") {
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
    </script>
@endsection