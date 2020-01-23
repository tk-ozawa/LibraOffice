@extends('layouts.order')

@section('title')
書籍ISBN検索フォーム
@endsection

@section('mainBody')
<form action="{{ route('search.order.input')}}" method="GET">
	@csrf
	ISBN<input type="text" name="ISBN" required>
	<br>
	第n版<input type="number" min="1" step="1" name="edition" value="1" required>
	<br>
	<button type="submit">検索</button>
</form>
@endsection
