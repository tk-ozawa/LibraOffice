@extends('layouts.userList')

@section('title')
ユーザー追加フォーム
@endsection

@section('body')
<form action="{{ route('user.add') }}" method="POST">
	@csrf
	<div class="form-group">
		名前
		<input class="form-control" type="text" name="name" required>
	</div>
	<div class="form-group">
		メールアドレス
		<input class="form-control" type="text" name="email" required>
	</div>
	<div class="form-group">
		<select class="form-control" name="auth">
			<option value="0">幹部以上</option>
			<option value="1">一般</option>
		</select>
	</div>
	<button class="btn btn-success" type="submit">この内容でユーザーを追加する</button>
</form>
@endsection
