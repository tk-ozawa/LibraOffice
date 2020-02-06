@extends('layouts.loginBase')

@section('body')
<div class="container">

@if(session('flashMsg'))
<div class="alert alert-success" role="alert">
	<span>{{ session('flashMsg') }}</span>
</div>
@endif

<a class="btn btn-success" href="{{ route('office.register.input') }}">オフィス登録</a>

<table class="table">
	<thead>
		<tr>
			<td>#</td>
			<td>オフィス名</td>
		</tr>
	</thead>
	<tbody>

	@foreach ($offices as $office)
		<tr>
			<td>
				{{ $office->id }}
			</td>
			<td>
				{{ $office->name }}
			</td>
		</tr>
	@endforeach
	</tbody>
</table>

</div>


@endsection
