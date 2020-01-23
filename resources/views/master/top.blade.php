@extends('layouts.list')

@section('title')
マスターTOPページ
@endsection

@section('otherList')
<h2>注文依頼リスト</h2>
@if($requests)
	<div class="table-responsive">
		<table class="table text-nowrap">
			<thead>
				<tr>
					<th scope="col" class="index-col">#</th>
					<th scope="col" class="btn-col"></th>
					<th scope="col" class="img-col">img</th>
					<th scope="col">title</th>
					<th scope="col">price</th>
					<th scope="col">categories</th>
				</tr>
			</thead>
			<tbody>
				@foreach($requests as $req)
				@php $book = $req['book']; @endphp
				<tr>
					<th scope="row" class="index-col">{{ $loop->iteration }}</th scope="row">
					<td class="btn-col"><a href="{{ route('order.accept.confirm', ['orderId' => $req['order']->id]) }}" class="btn btn-primary" target="_self">発注する</a></td>
					<td class="img-col"><a href="https://www.amazon.co.jp/s?k={{ $book->title }}&i=stripbooks"><img
								src="{{ $book->img_url }}"></a></td>
					<td><a href="https://www.amazon.co.jp/s?k={{ $book->title }}&i=stripbooks">{{ $book->title }}
							第{{ $book->edition }}版</a></td>
					<td>{{ $book->price }}円</td>
					<td>
						@foreach ($book->categories as $category)
						{{ $category['name'] }}
						@if(!$loop->last),@endif
						@endforeach
					</td>
				</tr>
				@if(!$loop->last) <br> @endif
				@endforeach
			</tbody>
		</table>
	</div>
@else
	<p>注文依頼は現在ありません。</p>
@endif

<h2>社内図書(発注中)リスト</h2>
@if($orderings)
	<div class="table-responsive">
		<table class="table text-nowrap">
			<thead>
				<tr>
					<th scope="col" class="index-col">#</th>
					<th scope="col" class="btn-col"></th>
					<th scope="col" class="img-col">img</th>
					<th scope="col">title</th>
					<th scope="col">price</th>
					<th scope="col" class="cat-col">categories</th>
					<th scope="col">accept_user</th>
					<th scope="col">purchase_date</th>
				</tr>
			</thead>
			<tbody>
				@foreach($orderings as $ordering)
				@php $book = $ordering['book']; @endphp
				<tr>
					<th scope="row" class="index-col">{{ $loop->iteration }}</th>
					<td class="btn-col"><a href="{{ route('purchase.complete.confirm', ['purchaseId' => $ordering['purchase']->id]) }}" class="btn btn-primary" target="_self">到着報告</a></td>
					<td class="img-col"><a href="https://www.amazon.co.jp/s?k={{ $book->title }}&i=stripbooks"><img
								src="{{ $book->img_url }}"></a></td>
					<td><a href="https://www.amazon.co.jp/s?k={{ $book->title }}&i=stripbooks">{{ $book->title }}
							第{{ $book->edition }}版</a></td>
					<td>{{ $book->price }}円</td>
					<td class="cat-col">
						@foreach ($book->categories as $category)
							{{ $category['name'] }}
							@if(!$loop->last),@endif
						@endforeach
					</td>
					<td>{{ $ordering['user']->name }}</td>
					<td>{{ $ordering['purchase']->purchase_date }}</td>
				</tr>
				@if(!$loop->last) <br> @endif
				@endforeach
			</tbody>
		</table>
	</div>
@else
	<p>発注中の書籍は現在ありません。</p>
@endif
@endsection
