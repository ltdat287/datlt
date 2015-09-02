@extends('master')

@section('title')
トップページ | 社員管理システム
@endsection

@section('header.h1')
社員管理システム
@endsection

@section('content.h2')
トップページ
@endsection

@section('content')
	<nav class="pure-menu pure-menu-horizontal">
		<ul class="pure-menu-list">
			<li class="pure-menu-item"><a href="" class="pure-menu-link pure-button">first</a></li>
			<li class="pure-menu-item"><a href="" class="pure-menu-link pure-button">back</a></li>
			<li class="pure-menu-item">...</li>
			<li class="pure-menu-item"><a href="#" class="pure-menu-link pure-button">3</a></li>
			<li class="pure-menu-item"><button class="pure-button pure-button-disabled">4</button></li>
			<li class="pure-menu-item"><a href="" class="pure-menu-link pure-button">5</a></li>
			<li class="pure-menu-item">...</li>
			<li class="pure-menu-item"><a href="" class="pure-menu-link pure-button">next</a></li>
			<li class="pure-menu-item"><a href="" class="pure-menu-link pure-button">last</a></li>
		</ul>
	</nav>

	<section>
		<table class="pure-table pure-table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>名前</th>
					<th>メールアドレス</th>
					<th>電話番号</th>
					<th>生年月日</th>
					<th>更新日時</th>
					<th>権限</th>
				</tr>
			</thead>
			<tbody>
				<tr class="pure-table-odd">
					@if ($users)
						@foreach ($users as $i => $user)
			            <tr {{ (($i % 2) == 0) ? '' : 'class=pure-table-odd' }}>
							<td>{{{ $user->id }}}</td>
							<td><a href="{{ url('/member/' . $user->id . '/detail') }}">{{{ $user->name }}}({{{ $user->kana }}})</a></td>
							<td>{{{ $user->email }}}</td>
							<td>{{{ $user->telephone_no }}}</td>
							<td>{{{ $user->birthday }}}</td>
							<td>{{{ $user->updated_at }}}</td>
							<td>{{{ $user->role }}}</td>
						</tr>
			            @endforeach
					@endif
				</tr>
			</tbody>
		</table>
	</section>

	<nav class="pure-menu pure-menu-horizontal">
		<ul class="pure-menu-list">
			<li class="pure-menu-item"><a href="" class="pure-menu-link pure-button">first</a></li>
			<li class="pure-menu-item"><a href="" class="pure-menu-link pure-button">back</a></li>
			<li class="pure-menu-item">...</li>
			<li class="pure-menu-item"><a href="" class="pure-menu-link pure-button">3</a></li>
			<li class="pure-menu-item><button class="pure-button pure-button-disabled">4</button></li>
			<li class="pure-menu-item"><a href="" class="pure-menu-link pure-button">5</a></li>
			<li class="pure-menu-item">...</li>
			<li class="pure-menu-item"><a href="" class="pure-menu-link pure-button">next</a></li>
			<li class="pure-menu-item"><a href="" class="pure-menu-link pure-button">last</a></li>
		</ul>
	</nav>
@endsection