@extends('layout.master')

@section('title')
追加（完了） | 社員管理システム
@endsection

@section('header.h1')
社員管理システム
@endsection

@section('content.h2')
{{ $label }}
@endsection

@section('content')
	<section>
		<p>
			{!! $message !!}
		</p>
		<div>
			<a class="pure-button pure-button-primary" href="{{ url('/search') }}">検索画面へ</a>
		</div>
	</section>
@endsection
