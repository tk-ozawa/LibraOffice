@extends('layouts.order')

@section('title')
書籍API検索フォーム
@endsection

@section('navLinkHref')
href="{{ route('search') }}"
@endsection

@section('mainBody')
<div class="container">

	<div style="text-align:center; margin-top:2rem; margin-bottom:2rem;">
		<img src="{{ $book->img_url }}">
	</div>

<form action="{{ route('order') }}" method="GET">
	@csrf
	<div class="form-group">
		ISBN：
		<input class="form-control" type="text" name="ISBN" value="{{ $book->ISBN }}" disabled>
	</div>
	<div class="form-group">
		タイトル：
		<input class="form-control" type="text" name="title" value="{{ $book->title }}" disabled>
	</div>
	<div class="form-group">
		価格
		<input class="form-control" type="text" name="price" value="{{ $book->price }}" disabled>
	</div>
	<div class="form-group">
		発売日
		<input class="form-control" type="text" name="release_date" value="{{ $book->release_date }}" disabled>
	</div>
	<div class="form-group">
		出版元
		<input class="form-control" type="text" name="publisher" value="{{ $publisher->name }}" disabled>
	</div>
	<div class="form-group">
		著者(複数の場合カンマ区切り)
		<input class="form-control" type="text" name="authors" value="{{ $book->authorsToString() }}" disabled>
	</div>
	<div class="form-group">
		カテゴリ(複数の場合カンマ区切り)
		<input class="form-control" type="text" name="categories" value="{{ $book->categoriesToString() }}" disabled>
	</div>
	<div class="form-group">
		版数
		<input class="form-control" type="text" name="edition" value="{{ $book->edition }}" disabled>
	</div>

	<input type="hidden" name="img_url" value="{{ $book->img_url }}">
	<input type="hidden" name="ISBN" value="{{ $book->ISBN }}">
	<input type="hidden" name="title" value="{{ $book->title }}">
	<input type="hidden" name="price" value="{{ $book->price }}">
	<input type="hidden" name="release_date" value="{{ $book->release_date }}">
	<input type="hidden" name="publisher" value="{{ $publisher->name }}">
	<input type="hidden" name="authors" value="{{ $book->authorsToString() }}">
	<input type="hidden" name="categories" value="{{ $book->categoriesToString() }}">
	<input type="hidden" name="edition" value="{{ $book->edition }}">

	<a class="btn btn-danger" href="{{ route('search') }}">戻る</a>
	<button class="btn btn-primary" type="submit">注文</button>
</form>
</div>

@endsection
