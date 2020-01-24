@extends('layouts.list')

@section('title')
マスターTOPページ
@endsection

@section('head')
<style>
#open1_wrapp {
	border: 5px solid khaki;
	border-radius: 25px;
	padding: 10px;
}
#open2_wrapp {
	border: 5px solid red;
	border-radius: 25px;
	padding: 10px;
}
.count_text {
	color: red;
	font-size: 17px;
}

</style>
@endsection

@section('otherList')
<div id="open1_wrapp">
	@if($requests)
	<div onclick="obj=document.getElementById('open1').style; obj.display=(obj.display=='none')?'block':'none';">
		<a style="cursor:pointer;"><h2>注文依頼リスト @if($requestsCount !== 0) <span class="count_text">{{ $requestsCount }}件あります</span> @endif</h2>　▼ クリックで展開</a>
	</div>
	<div id="open1" style="display:none;clear:both;">
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
	</div>
	@else
	<h2>注文依頼リスト</h2>
	<p>注文依頼は現在ありません。</p>
	@endif
</div>

<div id="open2_wrapp">
	@if($orderings)
	<div onclick="obj=document.getElementById('open2').style; obj.display=(obj.display=='none')?'block':'none';">
		<a style="cursor:pointer;"><h2>社内図書(発注中)リスト @if($orderingsCount !== 0) <span class="count_text">{{ $orderingsCount }}件あります</span> @endif</h2>　▼ クリックで展開</a>
	</div>
	<div id="open2" style="display:none;clear:both;">
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
	</div>
	@else
	<h2>社内図書(発注中)リスト</h2>
	<p>発注中の書籍は現在ありません。</p>
	@endif
</div>
@endsection
