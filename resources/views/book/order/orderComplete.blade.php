@extends('layouts.order')

@section('title')
書籍注文依頼完了
@endsection

@section('navLinkHref')
href="{{ route('search') }}"
@endsection

@section('mainBody')

<h2>注文依頼を送信しました。</h2>

タイトル:{{ $bookProp->title }}
<br>
ISBN:@if(empty($bookProp->ISBN)) なし @else {{ $bookProp->ISBN }} @endif
<br>
版数:@if(empty($bookProp->edition)) なし @else {{ $bookProp->edition }} @endif
<br>
価格:{{ $bookProp->price }}
<br>
発売日:{{ $bookProp->release_date }}
<br>
カテゴリ:
@foreach ($bookProp->categories as $category)
	@if (!$loop->first),@endif
	{{ $category->name }}
@endforeach
<br>
著者:
@foreach ($bookProp->authors as $author)
	@if (!$loop->first),@endif
	{{ $author->name }}
@endforeach
<br>
出版元:{{ $publisherProp->name }}

<br>
@if (session('auth') === 0)
	<a href="{{ route('master.top') }}">戻る</a>
@else
	<a href="{{ route('normal.top') }}">戻る</a>
@endif

@endsection
