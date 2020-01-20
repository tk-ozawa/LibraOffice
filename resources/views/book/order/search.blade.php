<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>書籍検索フォーム</title>
</head>
<body>
	@if (session('valiMsg'))
		<p>{{ session('valiMsg') }}</p>
		<p>手動入力フォームは <span><a href="/order/input">こちら</a></span></p>
	@elseif (session('infoMsg'))
		<p>{{ session('infoMsg') }}</p>
	@endif

	<form action="search/order/input" method="GET">
		@csrf
		ISBN<input type="text" name="ISBN" required>
		<br>
		第n版<input type="number" min="1" step="1" name="edition" value="1" required>
		<br>
		<button type="submit">検索</button>
	</form>
</body>
</html>
