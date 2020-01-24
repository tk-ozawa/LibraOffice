@extends('layouts.base')

@section('tplHead')
<link rel="stylesheet" href="{{ asset('css/list/base.css') }}">
@endsection

@section('navItem')
<li class="nav-item active">
	<a class="nav-link" href="@if(session('auth') === 0) {{ route('master.top')}} @else {{ route('normal.top') }} @endif">ホーム</a>
</li>
<li class="nav-item">
	<a class="nav-link" href="{{ route('search') }}">書籍登録</a>
</li>
@endsection

@section('body')
@if(session('flashMsg'))
<div class="alert alert-primary" role="alert">
	<span>{{ session('flashMsg') }}</span>
</div>
@endif

<div id="open_rentals_wrapp">
	@if($rentals)
	<div onclick="obj=document.getElementById('openRental').style; obj.display=(obj.display=='none')?'block':'none';">
		<a class="unfoldBtn"><h2>貸出中リスト @if($rentalsCount !== 0) <span class="count_text">{{ $rentalsCount }}件あります</span> @endif</h2>　▼ クリックで展開</a>
	</div>
	<div id="openRental" class="unfoldBox">
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
	</div>
	@else
	<h2>注文依頼リスト</h2>
	<p>注文依頼は現在ありません。</p>
	@endif
</div>

@yield('otherList')

<h2>社内図書リスト</h2>
@if($purchases)
<div class="table-responsive">
	<table class="table text-nowrap">
		<thead>
			<tr>
				<th scope="col" class="index-col">#</th>
				<th scope="col" class="btn-col"></th>
				<th scope="col" class="img-col">img</th>
				<th scope="col">title</th>
				<th scope="col" class="cat-col">categories</th>
				<th scope="col">purchase_date</th>
			</tr>
		</thead>
		<tbody>
			@foreach($purchases as $purchase)
				@php $book = $purchase['book']; @endphp
				<tr>
					<th scope="row" class="index-col">{{ $loop->iteration }}</th scope="row">
					<td class="btn-col">
						@if ($purchase['isRental'])
							@if ($purchase['rentalUserId'] === session('id'))
								<button class="btn btn-danger" onclick="ReturnCheck({{ $purchase['purchase']->id }}, '{{ $book->title }}');">返却する</button>
							@else
								<a class="btn btn-warning">貸出中</a>
							@endif
						@else
							<button class="btn btn-success" onclick="RentalCheck({{ $purchase['purchase']->id }}, '{{ $book->title }}');">借りて読む</button>
						@endif
					</td>
					<td class="img-col"><a href="{{ route('book.detail', ['purchaseId' => $purchase['purchase']->id]) }}"><img src="{{ $book->img_url }}"></a></td>
					<td><a href="{{ route('book.detail', ['purchaseId' => $purchase['purchase']->id]) }}">{{ $book->title }} 第{{ $book->edition }}版</a></td>
					<td class="cat-col">
						@foreach ($book->categories as $category)
							<a href="{{ route('book.find.category', ['categoryName' => $category['name']]) }}">{{ $category['name'] }}</a>
							@if(!$loop->last),@endif
						@endforeach
					</td>
					<td>{{ $purchase['purchase']->purchase_date }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
@else
<p>登録されている社内図書は現在ありません。</p>
@endif

<script>
function RentalCheck (purchaseId, bookTitle) {
	let res = confirm(`貸出申請しますか？${purchaseId}:${bookTitle}`)
	if ( res == true ) {
		// OKなら移動
		window.location.href = `/book/${purchaseId}/rental`
	}
}

function ReturnCheck (purchaseId, bookTitle) {
	let res = confirm(`返却しますか？${purchaseId}:${bookTitle}`)
	if ( res == true ) {
		// OKなら移動
		window.location.href = `/book/${purchaseId}/return`
	}
}
</script>
@endsection
