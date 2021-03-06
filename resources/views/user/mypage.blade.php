@extends('layouts.master')

@section('head')
<script src="http://platform.twitter.com/widgets.js"></script>
@endsection

@section('title')
マイページ
@endsection

@section('body')
<rentals-list-component
	get-url="{{ route('rentals.json') }}"
	login="{{ session('id') }}">
</rentals-list-component>

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


<h2>あなたがこれまでに得した金額</h2>
<p>(読んだ本の総額)</p>
<div style="display:flex">
	<p>{{ $profitMoney }}円</p>
	<a href="https://twitter.com/share" class="twitter-share-button"
	data-text="あなたが今までにLibraOfficeを使って得した金額は {{ $profitMoney }}円です！"
	data-lang="ja"
	data-count="vertical" data-hashtags="LibraOffice"
	></a>

</div>


<div class="px-4">
	<button type="button" class="btn btn-primary btn-block my-4" data-toggle="modal" data-target="#myModal">プロフィール編集</button>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title">プロフィール編集</h2>
				</div>
				<div class="modal-body">
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
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
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
@endsection
