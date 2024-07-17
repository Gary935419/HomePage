@extends('main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">アカウント削除</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- /.col-md-6 -->
                    <div class="col-lg-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0">ヒント</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    @if(isset($remove_user_result))
                                        <font size="3" color="#ff0000">{{$remove_user_result}}<br>アカウント削除の失敗。</font>
                                    @else
                                        @if(isset($removed_user_id))
                                            <font size="3" color="#2E1F1F">アカウント　{{$removed_user_id}}　正常に削除されました。</font>
                                        @endif
                                    @endif
                                </p>
                                <a href="/userinfo/admin_user_info" class="btn btn-primary">戻る</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
