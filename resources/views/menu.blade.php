<nav class="navbar navbar-default navbar-inverse">
	<ul class="navbar-nav nav">
		@if( !Auth::check() )
			<li class="@routeActive('/^login$/')"><a href="{{ route('login') }}">Login</a></li>
		@else
			<li class="@routeActive('/^home$/')"><a href="{{ route('home') }}">Home</a></li>
			<li class="@routeActive('/^profile$/')" ><a href="{{ route('profile') }}">Profile</a></li>
			<li class="@routeActive('/^picks/')" ><a href="{{ route('picks') }}">Picks</a></li>
			<li class="@routeActive('/^standings\./')" ><a href="{{ route('standings') }}">Standings</a></li>

			@if( Gate::allows('admin') )
				<li><a class="warning" href="{{ route('admin.results.index') }}">Admin</a></li>
			@endif

			<li><a class="danger" href="{{ route('logout') }}">Logout</a></li>
		@endif
	</ul>
	
	@include('auth.username')
</nav>
