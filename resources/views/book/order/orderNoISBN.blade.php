<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>書籍検索フォーム</title>
</head>
<body>
	<form action="/order" method="GET">
		@csrf
		タイトル<input type="text" name="title" required>
		<br>
		価格<input type="number" name="price" required>
		<br>
		発売日<input type="date" name="release_date" required>
		<br>
		出版元<input type="text" name="publisher" required>
		<br>
		著者(複数の場合カンマ区切り)<input type="text" name="authors" required>
		<br>
		カテゴリ(複数の場合カンマ区切り)<input type="text" name="categories" required>
		<br>
		版数(あれば)<input type="text" name="edition">
		<br>
		ISBN(あれば)<input type="text" name="ISBN">
		<br>
		<button type="submit">注文</button>
	</form>
</body>
</html>
