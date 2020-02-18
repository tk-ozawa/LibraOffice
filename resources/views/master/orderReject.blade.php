@extends('layouts.master')

@section('title')
注文依頼却下処理画面
@endsection

@section('body')
<h2><span style="color:red;">この注文を却下します</span></h2>

<table class="table">
	<tbody>
		<tr>
			<th>タイトル</th>
			<td>{{ $order->books->title }} 第{{ $order->books->edition }}版</td>
		</tr>
		<tr>
			<th>img</th>
			<td><img src="{{ $order->books->img_url }}"></td>
		</tr>
		<tr>
			<th>注文依頼ユーザー</th>
			<td>
				<a href="{{ route('user.detail', ['userId' => $order->requestUsers->id]) }}">
					{{ $order->requestUsers->name }}
				</a>
			</td>
		</tr>
	</tbody>
</table>

<form action="{{ route('order.reject') }}" method="GET">
	<div class="form-group">
		<input type="hidden" name="order_id" value="{{ $order->id }}">
		<label for="content">却下理由</label>
		<textarea class="form-control" name="content" id="content" cols="5" rows="5" placeholder="却下理由..." required></textarea>
	</div>
	<div class="row">
		<a href="{{ route('order.accept.confirm', ['orderId' => $order->id]) }}" class="btn btn-primary mx-3">
			戻る
		</a>
		<button type="submit" class="btn btn-danger">注文依頼を却下する</button>
	</div>
</form>
@endsection
