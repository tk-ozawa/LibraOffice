@extends('layouts.loginBase')

@section('body')
<div class="container">
	<form action="{{ route('office.register') }}" method="post">
		@csrf
		<div class="form-group">
			オフィス名
			<input class="form-control" type="text" name="office_name">
		</div>
		<div class="form-group">
			管理ユーザー名
			<input class="form-control" type="text" name="name">
		</div>
		<div class="form-group">
			管理ユーザーメールアドレス
			<input class="form-control" type="email" name="email">
		</div>
		<div class="form-group">
			管理ユーザーパスワード
			<input class="form-control" type="password" name="password">
		</div>
		<button class="btn btn-primary" type="submit">登録</button>
	</form>
</div>
@endsection
