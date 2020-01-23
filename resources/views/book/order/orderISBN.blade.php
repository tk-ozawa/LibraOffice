@extends('layouts.order')

@section('title')
書籍API検索フォーム
@endsection

@section('navLinkHref')
href="{{ route('search') }}"
@endsection

@section('mainBody')
<img src="{{ $book->img_url }}">

<form action="{{ route('order') }}" method="GET">
	@csrf
	ISBN：<input type="text" name="ISBN" value="{{ $book->ISBN }}" disabled>
	<br>
	タイトル：<input type="text" name="title" value="{{ $book->title }}" disabled>
	<br>
	価格<input type="text" name="price" value="{{ $book->price }}" disabled>
	<br>
	発売日<input type="text" name="release_date" value="{{ $book->release_date }}" disabled>
	<br>
	出版元<input type="text" name="publisher" value="{{ $publisher->name }}" disabled>
	<br>
	著者(複数の場合カンマ区切り)<input type="text" name="authors" value="{{ $book->authorsToString() }}" disabled>
	<br>
	カテゴリ(複数の場合カンマ区切り)<input type="text" name="categories" value="{{ $book->categoriesToString() }}" disabled>
	<br>
	版数<input type="text" name="edition" value="{{ $book->edition }}" disabled>
	<br>

	<input type="hidden" name="img_url" value="{{ $book->img_url }}">
	<input type="hidden" name="ISBN" value="{{ $book->ISBN }}">
	<input type="hidden" name="title" value="{{ $book->title }}">
	<input type="hidden" name="price" value="{{ $book->price }}">
	<input type="hidden" name="release_date" value="{{ $book->release_date }}">
	<input type="hidden" name="publisher" value="{{ $publisher->name }}">
	<input type="hidden" name="authors" value="{{ $book->authorsToString() }}">
	<input type="hidden" name="categories" value="{{ $book->categoriesToString() }}">
	<input type="hidden" name="edition" value="{{ $book->edition }}">

	<button type="submit">注文</button>
</form>
@endsection
