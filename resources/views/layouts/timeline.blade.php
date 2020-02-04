@extends('layouts.base')

@section('navItem')
<li class="nav-item">
	<a class="nav-link" href="@if(session('auth') === 0) {{ route('master.top')}} @else {{ route('normal.top') }} @endif">ホーム</a>
</li>
<li class="nav-item">
	<a class="nav-link" href="{{ route('search') }}">書籍登録</a>
</li>
<li class="nav-item active">
	<a class="nav-link">タイムライン</a>
</li>
@endsection
