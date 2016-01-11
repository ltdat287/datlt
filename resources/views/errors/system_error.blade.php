@extends('layout.master_system_error')

@section('description')
""
@endsection

@section('title')
エラー | 社員管理システム
@endsection

@section('header.h1')
社員管理システム
@endsection

@section('content.h2')
エラー
@endsection

@section('content')
<section>
	<section class="error-box">
		<h3>System Error</h3>
		<ul>
		@foreach ($errors as $error)
	    	<?php
	        // Write error to log.
	        Log::error($error);

	        // Display error to webpage
	       	$error = 'システムエラーが発生しました。';
	        ?>
			<li>{{ $error }}</li>
		@endforeach
		</ul>
	</section>
</section>

@endsection
