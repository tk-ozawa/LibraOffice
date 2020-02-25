@extends('layouts.order')

@section('title')
書籍ISBN検索フォーム
@endsection

@section('mainBody')
<div class="container">
<form action="{{ route('search.order.input')}}" method="GET">
	@csrf
	<div class="form-group">
		ISBN
		<input class="form-control" type="text" name="ISBN" required>
	</div>
	<div class="form-group">
		第n版
		<input class="form-control" type="number" min="1" step="1" name="edition" value="1" required>
	</div>
	<button type="submit" class="btn btn-primary">検索</button>
</form>
<br>
<p>手動入力フォームは <a href="{{ route('order.input') }}">こちら</a></p>
</div>

@endsection
