<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>@yield('title')</title>
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<script src="{{ asset('js/app.js') }}" defer></script>
	@yield('head')
</head>
<body>

<header>
	<nav class="navbar navbar-expand-md navbar-light" style="background-color: #e3f2fd;">
		<a class="navbar-brand" href="@if(session('auth') === 0) {{ route('master.top')}} @else {{ route('normal.top') }} @endif">LibraOffice</a>
		<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#Navber" aria-controls="Navber" aria-expanded="false" aria-label="ナビゲーションの切替">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="Navber">
			<ul class="navbar-nav mr-auto">
				@yield('navItem')
			</ul>
			<form class="form-inline my-2 my-lg-0">
				<input type="search" class="form-control mr-sm-2" placeholder="本のタイトル…" aria-label="本のタイトル…">
				<button type="submit" class="btn btn-outline-success my-2 my-sm-0">検索</button>
			</form>
		</div>
	</nav>
</header>

@yield('body')

</body>
</html>
