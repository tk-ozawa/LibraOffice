<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>@yield('title')</title>
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<script src="{{ asset('js/app.js') }}" defer></script>
	@yield('tplHead')
	@yield('head')
</head>
<body>

<header>
	<nav class="navbar navbar-expand-md navbar-light" style="background-color: #e3f2fd;">
		<a class="navbar-brand" href="{{ route('login') }}">LibraOffice</a>
	</nav>
</header>

@yield('body')

</body>
</html>
