<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>@yield('title') {{ config('app.name', 'Laravel') }}</title>

	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h1 class="hidden-xs">{{ config('app.name', 'Laravel') }} @yield('secondary')</h1>

				@section('menu')		
					@include('menu')
				@show
			</div>
		</div>
	</div>
	
	@yield('content')
	
	<footer class="container">
		<div class="row">
			<div class="col-xs-12">
				<p class="text-center">
					@lang('Thanks to :name for making the Glyphicon Halflings set free of use.', [ 'name' => '<a href="http://glyphicons.com/" target="_blank">Glyphicons</a>' ])
				</p>
				
				@if( env('APP_DEBUG') )
				<p class="text-center">
					{{ App\Listeners\DbListener::$count }} quer{{ App\Listeners\DbListener::$count == 1 ? 'y' : 'ies' }} executed.<br>
				</p>
				<ol>
					@foreach( App\Listeners\DbListener::queries() as $query )
						<li>{{ $query }}</li>
					@endforeach
				</ol>
				@endif
			</div>
		</div>
	</footer>

	<!-- Scripts -->
	<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
