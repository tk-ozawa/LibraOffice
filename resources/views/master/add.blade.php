<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>ユーザー追加</title>
</head>
<body>

	<form action="{{ route('user.add') }}" method="get">
		<ul>
			<li>
				名前：<input type="text" name="name" required>
			</li>
			<li>
				メールアドレス：<input type="text" name="email" required>
			</li>
			<li>
				<select name="auth">
					<option value="0">幹部以上</option>
					<option value="1">一般</option>
				</select>
			</li>
		</ul>

		<button type="submit">ユーザー追加</button>
	</form>

</body>
</html>