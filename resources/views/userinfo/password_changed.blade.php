@extends('main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">アカウント管理</h1>
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
                                <h5 class="m-0">パスワードの更新</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    <font size="3" color="#008080">パスワードが更新されました。</font>
                                    @if (isset($PASSWORD_EXPIRE_TIME))
                                        <br>
                                        <font size="3" color="#008080">現在のパスワードは{{$PASSWORD_EXPIRE_TIME}}。</font>
                                    @endif
                                </p>
{{--                                <a href="javascript:" onclick="self.location=document.referrer;" class="btn btn-primary">戻る</a>--}}
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
