@extends('layouts.master')

@section('title')
マイページ
@endsection

@section('body')

<div class="container">
	<h2 >プロフィール編集</h2>
	<a class="btn btn-secondary my-2" href="{{ route('mypage') }}">戻る</a>
	<div id="app">
		<profile-edit-component
			username="{{ $user->name }}"
			profile="{{ $user->profile }}"
			birthday="{{ $user->birthday }}"
			send_url="{{ route('mypage.profile.edit') }}"
			csrf_token="{{ csrf_token() }}"
			>
		</profile-edit-component>
	</div>
</div>

@endsection
