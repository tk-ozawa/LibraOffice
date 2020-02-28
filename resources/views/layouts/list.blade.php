@extends('layouts.base')

@section('tplHead')
<link rel="stylesheet" href="{{ asset('css/list/base.css') }}">
@endsection

@section('navItem')
<li class="nav-item active">
	<a class="nav-link" href="@if(session('auth') === 0) {{ route('master.top')}} @else {{ route('normal.top') }} @endif">ホーム</a>
</li>
<li class="nav-item">
	<a class="nav-link" href="{{ route('search') }}">書籍登録</a>
</li>
<li class="nav-item">
	<a class="nav-link" href="{{ route('timeline') }}">タイムライン</a>
</li>
<li class="nav-item">
	<a class="nav-link" href="{{ route('user.list') }}">社員一覧</a>
</li>
@endsection

@section('body')
@if(session('flashMsg'))
<div class="alert alert-success" role="alert">
	<span>{{ session('flashMsg') }}</span>
</div>
@endif

@if(session('valiMsg'))
<div class="alert alert-warning" role="alert">
	<span>{{ session('valiMsg') }}</span>
</div>
@endif

<div class="row">
	<div class="col-lg-9">
		@yield('otherList')

		<h2>社内図書リスト</h2>
		<purchases-list-component
			get-url="{{ route('purchases.json') }}"
			login="{{ session('id') }}">
		</purchases-list-component>
	</div>

	<div class="col-lg-3 ranking">
		<div class="row">
			<h3>貸出ランキング</h3>
			<ul class="ranking-contents">
				@foreach ($ranking as $rental)
					<li>
						<a href="{{ route('book.detail', ['purchaseId' => $rental->purchases->id]) }}">
							<img src="{{ $rental->purchases->books->img_url }}">
						</a>
						<a href="{{ route('book.detail', ['purchaseId' => $rental->purchases->id]) }}">
							<p class="ranking-title">{{ $loop->iteration }}位 {{ $rental->purchases->books->title }}</p>
						</a>
					</li>
				@endforeach
			</ul>
		</div>
	</div>
</div>
@endsection
