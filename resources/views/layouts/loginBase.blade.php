<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="icon" href="{{ asset('favicon.ico') }}">
	<title>@yield('title')</title>
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<script src="{{ asset('js/app.js') }}" defer></script>
	@yield('tplHead')
	@yield('head')
</head>
<body>

<header>
	<nav class="navbar navbar-expand-md navbar-light" style="background-color: #e3f2fd;">
		<a class="navbar-brand" href="{{ route('login.form') }}">
			<img src="{{ asset('img/logo.png') }}" style="height:30px;">
		</a>
		<div class="collapse navbar-collapse" id="Navber">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="btn btn-primary" href="{{ route('office.top') }}">OfficeTOP</a>
				</li>
			</ul>
		</div>
	</nav>
</header>

@yield('body')

</body>
</html>
