@extends('main')
@section('content')
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- CodeMirror -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/codemirror/codemirror.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/codemirror/theme/monokai.css') }}">
    <!-- Summernote -->
    <script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- CodeMirror -->
{{--    <script src="{{ asset('adminlte/plugins/codemirror/codemirror.js') }}"></script>--}}
{{--    <script src="{{ asset('adminlte/plugins/codemirror/mode/css/css.js') }}"></script>--}}
{{--    <script src="{{ asset('adminlte/plugins/codemirror/mode/xml/xml.js') }}"></script>--}}
{{--    <script src="{{ asset('adminlte/plugins/codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>--}}
{{--    <style>--}}
{{--        .ck-editor__editable {--}}
{{--            font-size: 50px;--}}
{{--            font-family: monospace;--}}
{{--        }--}}
{{--    </style>--}}
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Summernote Editor</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-body">
                          <textarea id="summernote" style="font-size: 20px;font-family: cursive">

                          </textarea>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <script>
        $(function () {
            // Summernote
            $('#summernote').summernote()

            // // CodeMirror
            // CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
            //     mode: "htmlmixed",
            //     theme: "monokai"
            // });
        })
    </script>
@endsection
