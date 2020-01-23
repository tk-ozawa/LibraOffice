@extends('layouts.base')

@section('navItem')
<li class="nav-item">
	<a class="nav-link" href="@if(session('auth') === 0) {{ route('master.top')}} @else {{ route('normal.top') }} @endif">ホーム</a>
</li>
<li class="nav-item active">
	<a class="nav-link" @yield('navLinkHref')>書籍登録</a>
</li>
@endsection

@section('body')
@if(session('valiMsg'))
<p>{{ session('valiMsg') }}</p>
<p>
	手動入力フォームは <span><a href="/order/input">こちら</a></span>
</p>
@elseif (session('infoMsg'))
<p>{{ session('infoMsg') }}</p>
@endif

@yield('mainBody')

@endsection
