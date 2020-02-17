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
	<nav class="navbar navbar-expand-md navbar-light" style="background-color: @if(session('auth') === 1)#e3f2fd; @else #607D8B; @endif">
		<a class="navbar-brand" href="@if(session('auth') === 0) {{ route('master.top')}} @else {{ route('normal.top') }} @endif">
			<img src="{{ asset('img/logo.png') }}" style="height:38px;">
		</a>
		<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#Navber" aria-controls="Navber" aria-expanded="false" aria-label="ナビゲーションの切替">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="Navber">
			<ul class="navbar-nav mr-auto">
				@yield('navItem')
			</ul>
			<form class="form-inline my-2 my-lg-0 mr-3" action="{{ route('book.find.title') }}" method="GET">
				<input type="search" name="keyword" class="form-control mr-sm-2" placeholder="本のタイトル…" aria-label="本のタイトル…">
				<button type="submit" class="btn btn-outline-success my-2 my-sm-0">検索</button>
			</form>
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="btn btn-primary" href="{{ route('mypage') }}">マイページ</a>
				</li>
			</ul>
		</div>
	</nav>
</header>

<div class="container">
	@yield('body')
</div>

<script>
function RentalCheck (purchaseId, bookTitle) {
	let res = confirm(`貸出申請しますか？${purchaseId}:${bookTitle}`)
	if ( res == true ) {
		// OKなら移動
		window.location.href = `/book/${purchaseId}/rental`
	}
}

function ReturnCheck (purchaseId, bookTitle) {
	let res = confirm(`返却しますか？${purchaseId}:${bookTitle}`)
	if ( res == true ) {
		// OKなら移動
		window.location.href = `/book/${purchaseId}/return`
	}
}
</script>
</body>
</html>
