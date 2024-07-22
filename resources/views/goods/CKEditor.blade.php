@extends('main')
@section('content')
    <script src="{{ asset('ckbox/ckbox.js') }}"></script>
    <script src="{{ asset('ckeditor/build/ckeditor.js') }}"></script>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>CK Editor</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="message">
                                <div class="centered">
                                    <h2>CKEditor 5 online builder demo - ClassicEditor build</h2>
                                </div>
                            </div>
                            <div class="centered">
                                <div class="row row-editor">
                                    <div class="editor-container" style="width: 100%">
                                        <div class="editor">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </section>
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
@endsection
