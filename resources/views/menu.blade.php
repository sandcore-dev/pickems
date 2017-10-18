<nav class="navbar navbar-default navbar-inverse">
	<ul class="navbar-nav nav">
		@if( !Auth::check() )
			<li><a href="{{ route('login') }}">Login</a></li>
		@else
			<li><a href="#">Home</a></li>
			<li><a href="#">Profile</a></li>
			<li><a href="#">Picks</a></li>
			<li><a href="#">Standings</a></li>

			@if( Gate::allows('admin') )
				<li><a class="warning" href="#">Admin</a></li>
			@endif

			<li><a href="{{ route('logout') }}">Logout</a></li>
		@endif
	</ul>
	
	@if( Auth::check() )
	<p class="navbar-text pull-right">Logged in as <a href="#">{{ Auth::user()->name }}</a></p>
	@endif
</nav>
