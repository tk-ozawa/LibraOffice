@extends('layouts.userList')

@section('title')
ユーザー詳細:{{ $user->name }}
@endsection

@section('body')
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
			<th>プロフィール</th>
			<td>{!! nl2br($user->profile) !!}</td>
		</tr>
	</tbody>
</table>

<h3>{{ $user->name }}さんが借りたことのある書籍</h3>

@if($rentals)
<p>{{ $rentals->count() }}件ヒットしました</p>
<div class="table-responsive">
	<table class="table text-nowrap">
		<thead>
			<tr>
				<th scope="col" class="index-col">#</th>
				<th scope="col" class="btn-col"></th>
				<th scope="col" class="img-col">img</th>
				<th scope="col">タイトル</th>
				<th scope="col">カテゴリ</th>
				<th scope="col">追加日</th>
			</tr>
		</thead>
		<tbody>
			@foreach($rentals as $ren)
			@php $book = $ren->purchases->books; @endphp
			<tr>
				<th scope="row" class="index-col">{{ $loop->iteration }}</th scope="row">
				<td class="btn-col">
					<button class="btn btn-danger" onclick="ReturnCheck({{ $ren->purchase_id }}, '{{ $book->title }}');">返却する</button>
				</td>
				<td class="img-col"><a href="{{ route('book.detail', ['purchaseId' => $ren->purchase_id]) }}"><img src="{{ $book->img_url }}"></a></td>
				<td><a href="{{ route('book.detail', ['purchaseId' => $ren->purchase_id]) }}">{{ $book->title }} 第{{ $book->edition }}版</a></td>
				<td class="cat-col">
					@foreach ($book->categories as $category)
						<a href="{{ route('book.find.category', ['categoryName' => $category['name']]) }}">{{ $category['name'] }}</a>
						@if(!$loop->last),@endif
					@endforeach
				</td>
				<td>{{ $ren->purchases->purchase_date }}</td>
				</tr>
			@if(!$loop->last) <br> @endif
			@endforeach
		</tbody>
	</table>
</div>
@else
<p>ヒットしませんでした。</p>
@endif
@endsection
