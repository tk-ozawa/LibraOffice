@extends('layouts.userList')

@section('title')
ユーザー追加完了ページ
@endsection

@section('body')
<h2>ユーザー追加完了</h2>

<table class="table">
	<tbody>
		<tr>
			<th>ユーザー名</th>
			<td>{{ $user->name }}</td>
		</tr>
		<tr>
			<th>メールアドレス</th>
			<td>{{ $user->email }}</td>
		</tr>
		<tr>
			<th>
				パスワード
				<p>(本来はパスワードをメールでお伝えします。)</p>
			</th>
			<td>{{ $password }}</td>
		</tr>
	</tbody>
</table>
<a class="btn btn-primary mt-2" href="{{ route('user.list') }}">一覧に戻る</a>
@endsection
