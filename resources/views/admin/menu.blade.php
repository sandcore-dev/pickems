<nav class="navbar navbar-default navbar-inverse">
	<ul class="navbar-nav nav">
		@if( Auth::check() )
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Series <span class="caret"></span></a>
				
				<ul class="dropdown-menu">
					<li class="{{ Route::currentRouteName() == 'admin.series.index' ? 'active' : '' }}"><a href="{{ route('admin.series.index') }}">Series</a></li>
					<li class="{{ Route::currentRouteName() == 'admin.seasons.index' ? 'active' : '' }}"><a href="{{ route('admin.seasons.index') }}">Seasons</a></li>
				</ul>
			</li>
			
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Races <span class="caret"></span></a>
				
				<ul class="dropdown-menu">
					<li class="{{ Route::currentRouteName() == 'admin.races.index' ? 'active' : '' }}"><a href="{{ route('admin.races.index') }}">Races</a></li>
					<li class="{{ Route::currentRouteName() == 'admin.circuits.index' ? 'active' : '' }}"><a href="{{ route('admin.circuits.index') }}">Circuits</a></li>
					
					<li role="separator" class="divider"></li>

					<li class="{{ Route::currentRouteName() == 'admin.countries.index' ? 'active' : '' }}"><a href="{{ route('admin.countries.index') }}">Countries</a></li>
				</ul>
			</li>
			
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Entries <span class="caret"></span></a>
				
				<ul class="dropdown-menu">
					<li class="{{ Route::currentRouteName() == 'admin.entries.index' ? 'active' : '' }}"><a href="{{ route('admin.entries.index') }}">Entries</a></li>
					
					<li role="separator" class="divider"></li>
			
					<li class="{{ Route::currentRouteName() == 'admin.drivers.index' ? 'active' : '' }}"><a href="{{ route('admin.drivers.index') }}">Drivers</a></li>
					<li class="{{ Route::currentRouteName() == 'admin.teams.index' ? 'active' : '' }}"><a href="{{ route('admin.teams.index') }}">Teams</a></li>
					
					<li role="separator" class="divider"></li>

					<li class="{{ Route::currentRouteName() == 'admin.countries.index' ? 'active' : '' }}"><a href="{{ route('admin.countries.index') }}">Countries</a></li>
				</ul>
			</li>
			
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Results <span class="caret"></span></a>
				
				<ul class="dropdown-menu">
					<li class="{{ Route::currentRouteName() == 'admin.results.index' ? 'active' : '' }}"><a href="{{ route('admin.results.index') }}">Results</a></li>
					<li class="{{ Route::currentRouteName() == 'admin.picks.index' ? 'active' : '' }}"><a href="{{ route('admin.picks.index') }}">Picks</a></li>
				</ul>
			</li>
			
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Users <span class="caret"></span></a>
				
				<ul class="dropdown-menu">
					<li class="{{ Route::currentRouteName() == 'admin.users.index' ? 'active' : '' }}"><a href="{{ route('admin.users.index') }}">Users</a></li>
					<li class="{{ Route::currentRouteName() == 'admin.leagues.index' ? 'active' : '' }}"><a href="{{ route('admin.leagues.index') }}">Leagues</a></li>
					
					<li role="separator" class="divider"></li>

					<li class="{{ Route::currentRouteName() == 'admin.userleagues.index' ? 'active' : '' }}"><a href="{{ route('admin.userleagues.index') }}">User's leagues</a></li>
				</ul>
			</li>
			
			<li><a class="warning" href="{{ route('home') }}">Return</a></li>

			<li><a class="danger" href="{{ route('logout') }}">Logout</a></li>
		@endif
	</ul>

	@include('auth.username')
</nav>
