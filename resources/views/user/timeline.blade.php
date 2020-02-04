@extends('layouts.timeline')

@section('title')
マイページ
@endsection

@section('body')

<div class="container">
	<table class="table">
		<tbody>
			@foreach ($timeline as $item)
				@php $user = $item->users; @endphp
				@php $purchase = $item->purchases; @endphp
				@php $book = $purchase->books; @endphp

				<tr>
					<td>
						{{ substr($item->created_at, 0, 10) }}
					</td>
					<td>
						{{ substr($item->created_at, 11, -3) }}
					</td>
					<td>
						<a href="{{ route('user.detail', ['userId' => $user->id]) }}">
							{{ $user->name }}
						</a>
						さんが
						<a href="{{ route('book.detail', ['purchaseId' => $purchase->id]) }}">
							{{ $book->title }}
						</a>
						を
						{{ $item->content }}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	{{ $timeline->links() }}
</div>

@endsection
