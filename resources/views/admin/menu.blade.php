<nav class="navbar navbar-default navbar-inverse">
	<ul class="navbar-nav nav">
		@if( Auth::check() )
			<li class="{{ Route::currentRouteName() == 'series.index' ? 'active' : '' }}"><a href="{{ route('series.index') }}">Series</a></li>
			
			<li><a class="warning" href="{{ route('home') }}">Return</a></li>

			<li><a class="danger" href="{{ route('logout') }}">Logout</a></li>
		@endif
	</ul>

	@include('auth.username')
</nav>
