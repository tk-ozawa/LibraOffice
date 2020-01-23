@extends('layouts.base')

@section('title')
ユーザー追加
@endsection

@section('body')
<form action="{{ route('user.add') }}" method="get">
	@csrf
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
@endsection
