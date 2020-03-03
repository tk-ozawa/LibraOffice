@extends('layouts.timeline')

@section('title')
タイムライン
@endsection

@section('body')

<div id="app">
	<div class="container">
		<timeline-component
			login="{{ session('id') }}"
			name="{{ session('name') }}"
		></timeline-component>
	</div>
</div>

@endsection
