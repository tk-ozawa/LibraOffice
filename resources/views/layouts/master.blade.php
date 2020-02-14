@extends('layouts.base')

@section('navItem')
<li class="nav-item">
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
