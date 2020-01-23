@extends('layouts.order')

@section('title')
書籍注文フォーム(ISBN無し)
@endsection

@section('navLinkHref')
href="{{ route('search') }}"
@endsection

@section('mainBody')
<form action="{{ route('order') }}" method="GET">
	@csrf
	タイトル<input type="text" name="title" required>
	<br>
	価格<input type="number" name="price" required>
	<br>
	発売日<input type="date" name="release_date" required>
	<br>
	出版元<input type="text" name="publisher" required>
	<br>
	著者(複数の場合カンマ区切り)<input type="text" name="authors" required>
	<br>
	カテゴリ(複数の場合カンマ区切り)<input type="text" name="categories" required>
	<br>
	版数(あれば)<input type="text" name="edition">
	<br>
	ISBN(あれば)<input type="text" name="ISBN">
	<br>
	<button type="submit">注文</button>
</form>
@endsection
