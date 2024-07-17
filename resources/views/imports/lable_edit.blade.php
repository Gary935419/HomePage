@extends('main')
@section('content')
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

        <section class="content">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
                        <form enctype="multipart/form-data" action="/imports/lable_edit" method="post" id="form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">タグ名</label>
                                    <input type="text" value="{{ $info['p_name'] }}" class="form-control" id="p_name" name="p_name" placeholder="タグ名">
                                </div>

                                <div class="form-group">
                                    <label>カテゴリ</label>
                                    <select class="form-control select2" name="p_type" id="p_type" style="width: 100%;">
                                        <option @if ($info['p_type']==1) selected @endif value="1">業種別</option>
                                        <option @if ($info['p_type']==2) selected @endif value="2">点呼種別</option>
                                        <option @if ($info['p_type']==3) selected @endif value="3">製品別</option>
                                        <option @if ($info['p_type']==4) selected @endif value="4">その他</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" value="{{ $info['id'] }}" name="id" id="id">
                                <a href="/imports/lable_lists" class="btn btn-secondary">戻る</a>
                                <button type="button" id="submit_btn" class="btn btn-success float-right">
                                    更新
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(function() {

            $('#submit_btn').click(function() {
                var errors_text = "";
                if ($('#p_name').val() == "") {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "タグ名を入力してください。";
                }

                if ($('#p_type').val() == 0) {
                    errors_text = errors_text + (strlen(errors_text) > 0 ? "<br/>" : "") + "カテゴリを入力してください。";
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
