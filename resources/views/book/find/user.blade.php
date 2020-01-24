@extends('layouts.book')

@section('title')
ユーザー貸出履歴検索:"{{ $user->name }}"
@endsection

@section('body')
<h1>"{{ $user->name }}"が借りたことのある書籍</h1>
<p>{{ $hitCount }}件ヒットしました。</p>

<div class="table-responsive">
	<table class="table text-nowrap">
		<thead>
			<tr>
				<th scope="col" class="index-col">#</th>
				<th scope="col" class="btn-col"></th>
				<th scope="col" class="img-col">img</th>
				<th scope="col">title</th>
				<th scope="col">categories</th>
				<th scope="col">purchase_date</th>
			</tr>
		</thead>
		<tbody>
			@foreach($hitRentals as $ren)
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

<script>
function ReturnCheck (purchaseId, bookTitle) {
	let res = confirm(`返却しますか？${purchaseId}:${bookTitle}`)
	if ( res == true ) {
		// OKなら移動
		window.location.href = `/book/${purchaseId}/return`
	}
}
</script>
@endsection
