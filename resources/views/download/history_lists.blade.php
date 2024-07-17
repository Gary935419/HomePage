@extends('main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>ダウンロード履歴</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form id="search-form" action="/download/history_lists" style="margin-bottom: 1%">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>お名前</label>
                                                <input type="text" value="{{ $user_name }}" placeholder="お名前" name="user_name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>会社名</label>
                                                <input type="text" value="{{ $company_name }}" placeholder="会社名" name="company_name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>電話番号</label>
                                                <input type="text" value="{{ $phone_number }}" placeholder="電話番号" name="phone_number" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>メール</label>
                                                <input type="text" value="{{ $email }}" placeholder="メール" name="email" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">検索</button>
                                </form>
                                <table id="table_show" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>お名前</th>
                                        <th>会社名</th>
                                        <th>電話番号</th>
                                        <th>メール</th>
                                        <th>ファイルパス</th>
                                        <th>同意フラグ</th>
                                        <th>作成時間</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($info as $v)
                                        <tr>
                                            <td>{{$v['user_name']}}</td>
                                            <td>{{$v['company_name']}}</td>
                                            <td>{{$v['phone_number']}}</td>
                                            <td>{{$v['email']}}</td>
                                            <td>{{$v['d_file_url']}}</td>
                                            <td>{{$v['agreement_flg_str']}}</td>
                                            <td>{{empty($v['CREATED_DT'])?'-':$v['CREATED_DT']}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <script>
        $(function () {
            $('.select2').select2();
        });
        $(function () {
            $("#table_show").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,"searching":false,
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                // "buttons": ["excel"]
            }).buttons().container().appendTo('#table_show_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection