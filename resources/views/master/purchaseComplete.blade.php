@extends('layouts.master')

@section('title')
発注完了申請確認
@endsection

@section('body')
<h2>この発注の到着処理を行いますか？</h2>

<table class="table">
	<tbody>
		<tr>
			<th>タイトル</th>
			<td>{{ $book->title }} 第{{ $book->edition }}版</td>
		</tr>
		<tr>
			<th>img</th>
			<td><img src="{{ $book->img_url }}"></td>
		</tr>
		<tr>
			<th>価格</th>
			<td>{{ $book->price }}</td>
		</tr>
		<tr>
			<th>ISBN</th>
			<td>{{ $book->ISBN }}</td>
		</tr>
		<tr>
			<th>発売日</th>
			<td>{{ $book->release_date }}</td>
		</tr>
		<tr>
			<th>発注ユーザー</th>
			<td>{{ $user->name }}</td>
		</tr>
		<tr>
			<th>発注日</th>
			<td>{{ $purchase->purchase_date }}</td>
		</tr>
	</tbody>
</table>

<form action="{{ route('purchase.complete') }}" method="get">
	<input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
	<button type="submit" class="btn btn-primary">この書籍の発注処理を完了する</button>
</form>
@endsection
