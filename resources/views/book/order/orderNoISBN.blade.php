@extends('layouts.order')

@section('title')
書籍注文フォーム(ISBN無し)
@endsection

@section('navLinkHref')
href="{{ route('search') }}"
@endsection

@section('mainBody')
<div class="container">
<form action="{{ route('order') }}" method="GET">
	@csrf
	<div class="form-group">
		タイトル　<span style="color:red; font-size:10px;">※必須</span>
		<input class="form-control" type="text" name="title" placeholder="マスタリングTCP/IP 入門編..." required>
	</div>
	<div class="form-group">
		価格　<span style="color:red; font-size:10px;">※必須</span>
		<input class="form-control" type="number" name="price" placeholder="1234" required>
	</div>
	<div class="form-group">
		発売日　<span style="color:red; font-size:10px;">※必須</span>
		<input class="form-control" type="date" name="release_date" required>
	</div>
	<div class="form-group">
		出版元　<span style="color:red; font-size:10px;">※必須</span>
		<input class="form-control" type="text" name="publisher" placeholder="オーム社" required>
	</div>
	<div class="form-group">
		著者(複数の場合カンマ区切り)　<span style="color:red; font-size:10px;">※必須</span>
		<input class="form-control" type="text" name="authors" required>
	</div>
	<div class="form-group">
		カテゴリ(複数の場合カンマ区切り)　<span style="color:red; font-size:10px;">※必須</span>
		<input class="form-control" type="text" name="categories" required>
	</div>
	<div class="form-group">
		版数(あれば)
		<input class="form-control" type="text" name="edition" placeholder="1">
	</div>
	<div class="form-group">
		ISBN(あれば)
		<input class="form-control" type="text" name="ISBN" placeholder="4274068765">
	</div>
	<a class="btn btn-danger" href="{{ route('search') }}">戻る</a>
	<button class="btn btn-primary" type="submit">注文</button>
</form>
</div>
@endsection
