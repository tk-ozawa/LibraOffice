@extends('layouts.book')

@section('title')
カテゴリでの検索:"{{ $category->name }}"
@endsection

@section('body')
<h1>"{{ $category->name }}"で検索</h1>
<p>{{ $hitCount }}件ヒットしました。</p>

@if($hitPurchases)
<div class="table-responsive">
	<table class="table text-nowrap">
		<thead>
			<tr>
				<th scope="col" class="index-col">#</th>
				<th scope="col" class="btn-col"></th>
				<th scope="col" class="img-col">img</th>
				<th scope="col">title</th>
				<th scope="col" class="cat-col">categories</th>
				<th scope="col">purchase_date</th>
			</tr>
		</thead>
		<tbody>
			@foreach($hitPurchases as $record)
				@php
					$purchase = $record['purchase'];
					$book = $purchase->books;
				@endphp
				<tr>
					<th scope="row" class="index-col">{{ $loop->iteration }}</th scope="row">
					<td class="btn-col">
						@if ($record['rental']['flg'])
							@if ($record['rental']['userId'] === session('id'))
								<button class="btn btn-danger" onclick="ReturnCheck({{ $purchase->id }}, '{{ $book->title }}');">返却する</button>
							@else
								<a class="btn btn-warning">貸出中</a>
							@endif
						@else
							<button class="btn btn-success" onclick="RentalCheck({{ $purchase->id }}, '{{ $book->title }}');">借りて読む</button>
						@endif
					</td>
					<td class="img-col"><a href="{{ route('book.detail', ['purchaseId' => $purchase->id]) }}"><img
								src="{{ $book->img_url }}"></a></td>
					<td><a href="{{ route('book.detail', ['purchaseId' => $purchase->id]) }}">{{ $book->title }}
							第{{ $book->edition }}版</a></td>
					<td class="cat-col">
						@foreach ($book->categories as $category)
							<a href="{{ route('book.find.category', ['categoryName' => $category->name]) }}">{{ $category->name }}</a>
							@if(!$loop->last),@endif
						@endforeach
					</td>
					<td>{{ $purchase->purchase_date }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
@else
<p>登録されている社内図書は現在ありません。</p>
@endif
@endsection
