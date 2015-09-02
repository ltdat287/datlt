@extends('master')

@section('title')
ログイン | 社員管理システム
@endsection

@section('header.h1')
社員管理システム
@endsection

@section('content.h2')
ログイン
@endsection

@section('content')
	<section>
	@if (count($errors) > 0)
		<section class="error-box">
			<h3>!!ERROR!!</h3>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{{ $error }}}</li>
				@endforeach
			</ul>
		</section>
	@endif
		<form class="pure-form" action="{{ url('/login') }}" method="POST">
			{!! csrf_field() !!}
			<fieldset class="pure-group">
				<input type="text" name="email" class="pure-input-1-4 required" placeholder="メールアドレス">
					@if ($errors->has('email'))
	        			@foreach ($errors->get('email') as $error ) 
	        			<section class="error-message">{{ $error }}</section>
	        			@endforeach
	        		@endif
				<input type="password" name="password" class="pure-input-1-4 required" placeholder="パスワード">
					@if ($errors->has('password'))
            			@foreach ($errors->get('password') as $error ) 
            			<section class="error-message">{{ $error }}</section>
            			@endforeach
            		@endif
			</fieldset>
			<button type="submit" class="pure-button pure-input-1-4 pure-button-primary">ログイン</button>
		</form>
	</section>
@endsection