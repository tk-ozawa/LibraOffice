@extends('layouts.base')

@section('navItem')
<li class="nav-item">
	<a class="nav-link" href="@if(session('auth') === 0) {{ route('master.top')}} @else {{ route('normal.top') }} @endif">ホーム</a>
</li>
<li class="nav-item active">
	<a class="nav-link" @yield('navLinkHref')>書籍登録</a>
</li>
<li class="nav-item">
	<a class="nav-link" href="{{ route('timeline') }}">タイムライン</a>
</li>
<li class="nav-item">
	<a class="nav-link" href="{{ route('user.list') }}">社員一覧</a>
</li>
@endsection

@section('body')
@if(session('valiMsg'))
<div class="alert alert-danger" role="alert">
	<span>{{ session('valiMsg') }}　手動入力フォームは <a href="/order/input">こちら</a></span>
</div>
@elseif (session('infoMsg'))
<div class="alert alert-warning" role="alert">
	<span>{{ session('infoMsg') }}</span>
</div>
@endif

@yield('mainBody')

@endsection
