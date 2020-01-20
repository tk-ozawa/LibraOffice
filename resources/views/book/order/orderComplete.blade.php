<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>書籍注文依頼完了画面</title>
</head>
<body>
	<h2>注文依頼を送信しました。</h2>

	タイトル:{{ $bookProp->title }}
	<br>
	ISBN:@if(empty($bookProp->ISBN)) なし @else {{ $bookProp->ISBN }} @endif
	<br>
	版数:@if(empty($bookProp->edition)) なし @else {{ $bookProp->edition }} @endif
	<br>
	価格:{{ $bookProp->price }}
	<br>
	発売日:{{ $bookProp->release_date }}
	<br>
	カテゴリ:
	@foreach ($bookProp->categories as $category)
		@if (!$loop->first),@endif
		{{ $category->name }}
	@endforeach
	<br>
	著者:
	@foreach ($bookProp->authors as $author)
		@if (!$loop->first),@endif
		{{ $author->name }}
	@endforeach
	<br>
	出版元:{{ $publisherProp->name }}
</body>
</html>
