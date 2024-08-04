@extends('main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>並び順設定</h1>
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
                        <div class="card-body" id="sortable">
                            @foreach($info as $v)
                                <div class="card card-primary card-outline" style="cursor: pointer" data-id="{{$v['id']}}">
                                    <div class="card-body">
{{--                                        <h5 class="card-title">{{$v['n_open_date']}}</h5>--}}
                                        <p class="card-text">
                                            {{$v['l_name']}}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="/seminar/teacher_lists" class="btn btn-secondary">戻る</a>
                            <button type="button" id="submit_btn" class="btn btn-success float-right">
                                設定
                            </button>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <script>
        $(function() {
            $("#sortable").sortable({
                update: function(event, ui) {
                    var sortedIDs = $("#sortable").sortable("toArray", { attribute: "data-id" });
                    console.log("Sorted IDs: ", sortedIDs);
                }
            });
            $("#sortable").disableSelection();
        });
    </script>
    <script>
        $(function() {
            $('#submit_btn').click(function() {
                var sortedIDs = $("#sortable").sortable("toArray", { attribute: "data-id" });
                var confirm_text = '並び順設定してよろしいですか？';
                $.confirm({
                    title: false,
                    theme: 'white',
                    content: confirm_text,
                    confirmButton: 'はい',
                    cancelButton: 'いいえ',
                    confirmButtonClass: 'btn-info',
                    cancelButtonClass: 'btn-danger',
                    confirm: function() {
                        var url = "/api/seminar/teacher_sort";
                        var params = {};
                        params.sortedIDs = sortedIDs;
                        ajax.post(url, params, function(data) {
                            if (data['RESULT'] == "OK") {
                                location.href = "/seminar/teacher_lists?msg_code=200&&msg="+'並び順設定が完了しました。';
                            } else {
                                location.href = "/seminar/teacher_lists?msg_code=201&&msg="+data['MESSAGE'];
                            }
                        });
                    },
                });
            });
        });
    </script>

@endsection
