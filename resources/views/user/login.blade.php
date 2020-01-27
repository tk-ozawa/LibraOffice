@extends('layouts.loginBase')

@section('title')
ログイン - LibraOffice
@endsection

@section('body')
@if(session('valiMsg'))
<div class="alert alert-warning" role="alert">
	<span>{{ session('valiMsg') }}</span>
</div>
@endif
@if(session('flashMsg'))
<div class="alert alert-success" role="alert">
	<span>{{ session('flashMsg') }}</span>
</div>
@endif

<main class="login-form">
	<div class="cotainer">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">ログイン</div>
					<div class="card-body">
						<form action="{{ route('login') }}" method="POST">
							@csrf
							<div class="form-group row">
								<label for="email_address" class="col-md-4 col-form-label text-md-right">メールアドレス</label>
								<div class="col-md-6">
									<input type="text" id="email_address" class="form-control" name="email" required autofocus>
								</div>
							</div>

							<div class="form-group row">
								<label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>
								<div class="col-md-6">
									<input type="password" id="password" class="form-control" name="password" required>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-6 offset-md-4">
									<div class="checkbox">
										<label>
											<input type="checkbox" id="password-display">パスワードを表示
										</label>
									</div>
								</div>
							</div>

							<div class="col-md-6 offset-md-4">
								<button type="submit" class="btn btn-primary">
									ログイン
								</button>
								{{-- <a href="#" class="btn btn-link">
									Forgot Your Password?
								</a> --}}
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>

</main>

<script>
	const pwd = document.getElementById('password');
	const pwdCheck = document.getElementById('password-display');
	pwdCheck.addEventListener('change', function() {
		if(pwdCheck.checked) {
			pwd.setAttribute('type', 'text');
		} else {
			pwd.setAttribute('type', 'password');
		}
	}, false);
</script>
@endsection
