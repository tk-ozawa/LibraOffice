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
					{{ $category->id }}:{{ $category->name }}
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
					{{ $author->id }}:{{ $author->name }}
					@if(!$loop->last),@endif
				@endforeach
			</td>
		</tr>
		<tr>
			<th>出版社</th>
			<td>{{ $publisher->name }}</td>
		</tr>
		<tr>
			<th>読んだことがある人</th>
			<td>
				@foreach ($users as $user)
					{{ $user->id }}:{{ $user->name }}
					@if(!$loop->last),@endif
				@endforeach
			</td>
		</tr>
	</tbody>
</table>

<form action="{{ route('book.rental', ['purchaseId' => $purchase->id]) }}" method="get">
	@if($isRental)
		<a class="btn btn-warning">貸出中</a>
	@else
		<button type="submit" class="btn btn-success">借りて読む</button>
	@endif
</form>
@endsection
