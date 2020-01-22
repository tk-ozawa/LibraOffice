<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>TOP</title>
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<base target="_blank">
</head>

<body>

	@if(session('flashMsg'))
		<p>{{ session('flashMsg') }}</p>
	@endif

	<a href="{{ route('search') }}">書籍登録</a>

	<br>

	<h2>注文依頼リスト</h2>

	@if(!$requests)
		<p>注文依頼は現在ありません。</p>
	@else
		<table class="table">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">img</th>
					<th scope="col">title</th>
					<th scope="col">price</th>
					<th scope="col">categories</th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
				@foreach($requests as $req)
				@php $book = $req['book']; @endphp
				<tr>
					<th scope="row">{{ $loop->iteration }}</th scope="row">
					<td><a href="https://www.amazon.co.jp/s?k={{ $book->title }}&i=stripbooks"><img
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
					<td><a href="{{ route('order.accept.confirm', ['orderId' => $req['order']->id]) }}" class="btn btn-primary" target="_self">発注する</a></td>
				</tr>
				@if(!$loop->last) <br> @endif
				@endforeach
			</tbody>
		</table>
	@endif

	<h2>社内図書(発注中)リスト</h2>
	@if(!$orderings)
		<p>発注中の書籍は現在ありません。</p>
	@else
		<table class="table">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">img</th>
					<th scope="col">title</th>
					<th scope="col">price</th>
					<th scope="col">categories</th>
					<th scope="col">accept_user</th>
					<th scope="col">purchase_date</th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
				@foreach($orderings as $ordering)
				@php $book = $ordering['book']; @endphp
				<tr>
					<th scope="row">{{ $loop->iteration }}</th scope="row">
					<td><a href="https://www.amazon.co.jp/s?k={{ $book->title }}&i=stripbooks"><img
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
					<td>{{ $ordering['user']->name }}</td>
					<td>{{ $ordering['purchase']->purchase_date }}</td>
					<td><a href="{{ route('purchase.complete.confirm', ['purchaseId' => $ordering['purchase']->id]) }}" class="btn btn-primary" target="_self">到着報告</a></td>
				</tr>
				@if(!$loop->last) <br> @endif
				@endforeach
			</tbody>
		</table>
	@endif

	<h2>社内図書リスト</h2>
	@if(!$purchases)
		<p>登録されている社内図書は現在ありません。</p>
	@else
		<table class="table">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">img</th>
					<th scope="col">title</th>
					<th scope="col">categories</th>
					<th scope="col">purchase_date</th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
				@foreach($purchases as $purchase)
				@php $book = $purchase['book']; @endphp
				<tr>
					<th scope="row">{{ $loop->iteration }}</th scope="row">
					<td><a href="https://www.amazon.co.jp/s?k={{ $book->title }}&i=stripbooks"><img
								src="{{ $book->img_url }}"></a></td>
					<td><a href="https://www.amazon.co.jp/s?k={{ $book->title }}&i=stripbooks">{{ $book->title }}
							第{{ $book->edition }}版</a></td>
					<td>
						@foreach ($book->categories as $category)
							{{ $category['name'] }}
							@if(!$loop->last),@endif
						@endforeach
					</td>
					<td>{{ $purchase['purchase']->purchase_date }}</td>
					<td><a class="btn btn-primary" target="_self">貸出申請</a></td>
				</tr>
				@if(!$loop->last) <br> @endif
				@endforeach
			</tbody>
		</table>
	@endif

</body>

</html>
