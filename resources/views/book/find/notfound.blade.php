@extends('layouts.book')

@section('title')
Not Found
@endsection

@section('body')
<h1>Not Found</h1>
<p>{{ $valiMsg }}</p>

<form class="form-inline my-2" action="{{ route('book.find.title') }}" method="GET">
	検索しますか？
	<input type="search" name="keyword" class="form-control mr-sm-2" placeholder="本のタイトル…" aria-label="本のタイトル…">
	<button type="submit" class="btn btn-outline-success my-2 my-sm-0">検索</button>
</form>
@endsection
