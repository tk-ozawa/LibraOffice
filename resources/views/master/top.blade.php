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

<a href="{{ route('search') }}">書籍登録</a>

<br>

<h2>注文依頼リスト</h2>

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
				<td><a href="https://www.amazon.co.jp/s?k={{ $book->title }}&i=stripbooks"><img src="{{ $book->img_url }}"></a></td>
				<td><a href="https://www.amazon.co.jp/s?k={{ $book->title }}&i=stripbooks">{{ $book->title }} 第{{ $book->edition }}版</a></td>
				<td>{{ $book->price }}円</td>
				<td>
					@foreach ($book->categories as $category)
						{{ $category['name'] }}
						@if(!$loop->last),@endif
					@endforeach
				</td>
				<td><button class="btn btn-primary">注文する</button></td>
			</tr>
			@if(!$loop->last) <br> @endif
		@endforeach
	</tbody>
</table>

<h2>社内図書(発注中)リスト</h2>

<h2>社内図書リスト</h2>
</body>
</html>
