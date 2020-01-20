<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>書籍注文確認フォーム</title>
</head>
<body>
	<form action="/order" method="GET">
		@csrf
		イメージ：{{ $book->img_url }}

		タイトル：{{ $book->title }}
		<br>
		価格：{{ $book->price }}
		<br>
		発売日：{{ $book->release_date }}
		<br>
		出版元：{{ $publisher->name }}
		<br>
		著者(複数の場合カンマ区切り)：{{ $book->authorsToString() }}
		<br>
		カテゴリ(複数の場合カンマ区切り)：{{ $book->categoriesToString() }}
		<br>
		版数：{{ $book->edition }}
		<br>
		ISBN：{{ $book->ISBN }}

		<button type="submit">注文</button>
	</form>
</body>
</html>
