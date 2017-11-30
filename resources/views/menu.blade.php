<nav class="navbar navbar-default navbar-inverse">
	<div class="container-fluid visible-xs">
		<div class="navbar-header">
			<a href="/" class="navbar-brand">{{ config('app.name', 'Laravel') }} @yield('secondary')</a>

			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			
		</div>
	</div>
	
	<div class="collapse navbar-collapse" id="menu">
		<ul class="navbar-nav nav">
			@if( !Auth::check() )
				<li class="@routeActive('/^login$/')"><a href="{{ route('login') }}">Login</a></li>
			@else
				<li class="@routeActive('/^profile$/')" ><a href="{{ route('profile') }}">Profile</a></li>
				<li class="@routeActive('/^picks/')" ><a href="{{ route('picks') }}">Picks</a></li>
				<li class="@routeActive('/^standings\./')" ><a href="{{ route('standings') }}">Standings</a></li>

				<li class="dropdown @routeActive('/^statistics\./')">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Statistics <span class="caret"></span></a>
				
					<ul class="dropdown-menu">
						<li class="@routeActive('/^statistics\.season$/') hidden-xs"><a href="{{ route('statistics.season') }}">Season performance</a></li>
						<li class="@routeActive('/^statistics\.history$/')"><a href="{{ route('statistics.history') }}">Historical records</a></li>
						<li class="@routeActive('/^statistics\.fame$/')"><a href="{{ route('statistics.fame') }}">Hall of Fame</a></li>
					</ul>
				</li>

				@if( Gate::allows('admin') )
					<li><a class="warning" href="{{ route('admin.results.index') }}">Admin</a></li>
				@endif

				<li><a class="danger" href="{{ route('logout') }}">Logout</a></li>
			@endif
		</ul>
	
		@include('auth.username')
	</div>
</nav>
