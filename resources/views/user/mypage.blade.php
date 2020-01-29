@extends('layouts.master')

@section('title')
マイページ
@endsection

@section('body')

<div class="container">

<h2>貸出中リスト</h2>
@if($rentals)
<div class="table-responsive">
	<table class="table text-nowrap table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th scope="col">タイトル</th>
				<th scope="col">借りた日</th>
				<th scope="col">ボタン</th>
			</tr>
		</thead>
		<tbody>
		@foreach($rentals as $ren)
			@php $book = $ren->purchases->books; @endphp
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>
					<a href="{{ route('book.detail', ['purchaseId' => $ren->purchase_id]) }}">
					{{ $book->title }} 第{{ $book->edition }}版
					</a>
				</td>
				<td>{{ substr($ren->created_at, 0, 10) }}</td>
				<td><button class="btn btn-danger" onclick="ReturnCheck({{ $ren->purchase_id }}, '{{ $book->title }}');">返却する</button></td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
@else
<p>貸出中の書籍は現在ありません。</p>
@endif

<h2>貸出履歴</h2>
@if (!$rentalsHistory)
	<p>履歴がありません。</p>
@else
<div class="table-responsive">
	<table class="table text-nowrap table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th scope="col">タイトル</th>
				<th scope="col">借りた日</th>
				<th scope="col">返した日</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($rentalsHistory as $rental)
			@php $book = $rental->purchases->books; @endphp

			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>
					<a href="{{ route('book.detail', ['purchaseId' => $rental->purchases->id]) }}">
						{{ $book->title }} 第{{ $book->edition }}版
					</a>
				</td>
				<td>{{ substr($rental->created_at, 0, 10) }}</td>
				<td>{{ substr($rental->updated_at, 0, 10) }}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
@endif

<div class="px-4">
	<button type="button" class="btn btn-primary btn-block my-4" data-toggle="modal" data-target="#myModal">プロフィール編集</button>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<h2>プロフィール編集</h2>
				<div id="app">
					<profile-edit-component
						username="{{ $loginUser->name }}"
						summary="{{ $loginUser->profile }}"
						date="{{ $loginUser->birthday }}"
						send_url="{{ route('mypage.profile.edit') }}"
						csrf_token="{{ csrf_token() }}"
						>
					</profile-edit-component>
				</div>
			</div>
		</div>
	</div>

	<a class="btn btn-success btn-block my-4" href="@if ($loginUser->auth === 0) {{ route('mypage.settings.master') }} @else {{ route('mypage.settings.normal') }} @endif">設定</a>

	<form action="{{ route('logout') }}" method="POST">
		@csrf
		<button class="btn btn-danger btn-block" type="submit">ログアウト</button>
	</form>
</div>

</div>

@endsection
