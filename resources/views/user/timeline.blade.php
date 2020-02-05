@extends('layouts.timeline')

@section('title')
マイページ
@endsection

@section('body')

<div id="app">
	<div class="container">
		<timeline-component
			login="{{ session('id') }}"
			name="{{ session('name') }}"
			token="{{ csrf_token() }}"
		></timeline-component>
	</div>
</div>

@endsection
