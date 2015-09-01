<!DOCTYPE html>
<html lang="ja">
<head>
	<meta content="" name="description">
	<title>@yield('title')</title>
	<link href="/" rel="canonical">
	<link rel="stylesheet" href="./css/pure-min.css">
	<link rel="stylesheet" href="./css/custom.css">
</head>
<body>

<header>
	<nav class="home-menu pure-menu pure-menu-horizontal relative">
		<h1 class="pure-menu-heading"><a href="{{ url('/') }}">@yield('header.title')</a></h1>
		@include('common.navigation')
	</nav>
</header>

@yield('content')

@include('common.footer')

</body>
</html>