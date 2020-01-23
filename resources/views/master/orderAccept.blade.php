@extends('layouts.master')

@section('title')
注文依頼承諾確認
@endsection

@section('body')
<h2>この注文依頼を承諾(発注)しますか？</h2>

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
			<th>注文依頼ユーザー</th>
			<td>{{ $user->name }}</td>
		</tr>
	</tbody>
</table>

<form action="{{ route('order.accept') }}" method="get">
	<input type="hidden" name="order_id" value="{{ $order->id }}">
	<button type="submit" class="btn btn-primary">この書籍を発注する</button>
</form>
@endsection
