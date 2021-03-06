@extends('layouts.book')

@section('title')
書籍詳細 / {{ $book->title }}
@endsection

@section('body')
<h1>書籍詳細ページ</h1>

<table class="table">
	<tbody>
		<tr>
			<th>タイトル</th>
			<td>
				<a href="https://www.amazon.co.jp/s?k={{ $book->title }}&i=stripbooks" target="_blank">{{ $book->title }}第{{ $book->edition }}版</a>
			</td>
		</tr>
		<tr>
			<th>img</th>
			<td>
				<a href="https://www.amazon.co.jp/s?k={{ $book->title }}&i=stripbooks" target="_blank"><img src="{{ $book->img_url }}"></a>
			</td>
		</tr>
		<tr>
			<th>カテゴリ</th>
			<td>
				@foreach ($categories as $category)
					<a href="{{ route('book.find.category', ['categoryName' => $category->name]) }}">{{ $category->name }}</a>
					@if(!$loop->last),@endif
				@endforeach
			</td>
		</tr>
		<tr>
			<th>発売日</th>
			<td>{{ $book->release_date }}</td>
		</tr>
		<tr>
			<th>著者</th>
			<td>
				@foreach ($authors as $author)
					<a href="{{ route('book.find.author', ['authorId' => $author->id]) }}">{{ $author->name }}</a>
					@if(!$loop->last),@endif
				@endforeach
			</td>
		</tr>
		<tr>
			<th>出版社</th>
			<td><a href="{{ route('book.find.publisher', ['publisherId' => $publisher->id]) }}">{{ $publisher->name }}</a></td>
		</tr>
		<tr>
			<th>読んだことがある人:借りた回数</th>
			<td>
				@foreach ($rentals as $rental)
					<a href="{{ route('user.detail', ['userId' => $rental['user']->id]) }}">{{ $rental['user']->name }}</a>
					{{ $rental['count'] }}回
					@if(!$loop->last),@endif
				@endforeach
			</td>
		</tr>
	</tbody>
</table>

@if($isRentalUserArr['flg'])
	@if($isRentalUserArr['userId'] === session('id'))
		<button class="btn btn-danger" onclick="ReturnCheck('{{ env('MIX_REMOTE_BASE_URL') }}', {{ $purchase->id }}, '{{ $book->title }}');">返却する</button>
	@else
		<a class="btn btn-warning">貸出中</a>
	@endif
@else
<form action="{{ route('book.rental', ['purchaseId' => $purchase->id]) }}" method="get">
		<button type="submit" class="btn btn-success">借りて読む</button>
</form>
@endif
@endsection
