@extends('layouts.userList')

@section('title')
ユーザーリスト
@endsection

@section('body')
@if(session('auth') === 0)
	<a class="btn btn-success my-3" href="{{ route('user.add.input') }}">社員登録</a>
@endif

<div class="card-columns">
@foreach ($users as $user)
	<div class="card" style="width: 14rem;">
		<div style="margin-top:1rem;text-align:center">
			<img class="card-img-top"
				src="/img/user/{{ $user->auth }}.png"
				style="width: 50%;">
		</div>
		<div class="card-body">
			<h4 class="card-title">{{ $user->name }}さん</h4>
			<a href="{{ route('user.detail', ['userId' => $user->id]) }}" class="btn btn-primary">プロフィール</a>
		</div>
	</div>
@endforeach
</div>
@endsection
