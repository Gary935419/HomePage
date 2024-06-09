@extends('main')

@section('content')
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header" style="color:red;">错误</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	@if (isset($ERROR_MESSAGE))
		{{$ERROR_MESSAGE}}
	@else
        加载过程中发生了意想不到的错误。
	@endif
	<br>
	<br>
	<button type="button" class="btn btn-primary" onclick="history.back();">返回</button>
</div>
@endsection
