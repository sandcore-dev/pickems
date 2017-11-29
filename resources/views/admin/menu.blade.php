<nav class="navbar navbar-default navbar-inverse">
	<ul class="navbar-nav nav">
		@if( Auth::check() )
			<li class="dropdown @routeActive('/^admin\.(series|seasons)\./')">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Series <span class="caret"></span></a>
				
				<ul class="dropdown-menu">
					<li class="@routeActive('/^admin\.series\./')"><a href="{{ route('admin.series.index') }}">Series</a></li>
					<li class="@routeActive('/^admin\.seasons\./')"><a href="{{ route('admin.seasons.index') }}">Seasons</a></li>
				</ul>
			</li>
			
			<li class="dropdown @routeActive('/^admin\.(races|circuits)\./')">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Races <span class="caret"></span></a>
				
				<ul class="dropdown-menu">
					<li class="@routeActive('/^admin\.races\./')"><a href="{{ route('admin.races.index') }}">Races</a></li>
					<li class="@routeActive('/^admin\.circuits\./')"><a href="{{ route('admin.circuits.index') }}">Circuits</a></li>
				</ul>
			</li>
			
			<li class="dropdown @routeActive('/^admin\.(entries|drivers|teams|countries)\./')">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Entries <span class="caret"></span></a>
				
				<ul class="dropdown-menu">
					<li class="@routeActive('/^admin\.entries\./')"><a href="{{ route('admin.entries.index') }}">Entries</a></li>
					
					<li role="separator" class="divider"></li>
			
					<li class="@routeActive('/^admin\.drivers\./')"><a href="{{ route('admin.drivers.index') }}">Drivers</a></li>
					<li class="@routeActive('/^admin\.teams\./')"><a href="{{ route('admin.teams.index') }}">Teams</a></li>
					
					<li role="separator" class="divider"></li>

					<li class="@routeActive('/^admin\.countries\./')"><a href="{{ route('admin.countries.index') }}">Countries</a></li>
				</ul>
			</li>
			
			<li class="dropdown @routeActive('/^admin\.(results|picks)\./')">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Results <span class="caret"></span></a>
				
				<ul class="dropdown-menu">
					<li class="@routeActive('/^admin\.results\./')"><a href="{{ route('admin.results.index') }}">Results</a></li>
					<li class="@routeActive('/^admin\.picks\./')"><a href="{{ route('admin.picks.index') }}">Picks</a></li>
				</ul>
			</li>
			
			<li class="dropdown @routeActive('/^admin\.(users|leagues|userleagues)\./')">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Users <span class="caret"></span></a>
				
				<ul class="dropdown-menu">
					<li class="@routeActive('/^admin\.users\./')"><a href="{{ route('admin.users.index') }}">Users</a></li>
					<li class="@routeActive('/^admin\.leagues\./')"><a href="{{ route('admin.leagues.index') }}">Leagues</a></li>
					
					<li role="separator" class="divider"></li>

					<li class="@routeActive('/^admin\.userleagues\./')"><a href="{{ route('admin.userleagues.index') }}">User's leagues</a></li>
				</ul>
			</li>
			
			<li><a class="warning" href="{{ route('picks') }}">Return</a></li>

			<li><a class="danger" href="{{ route('logout') }}">Logout</a></li>
		@endif
	</ul>

	@include('auth.username')
</nav>
