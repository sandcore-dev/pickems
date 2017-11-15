<nav class="navbar navbar-default navbar-inverse">
	<ul class="navbar-nav nav">
		@if( Auth::check() )
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Series <span class="caret"></span></a>
				
				<ul class="dropdown-menu">
					<li class="{{ Route::currentRouteName() == 'series.index' ? 'active' : '' }}"><a href="{{ route('series.index') }}">Series</a></li>
					<li class="{{ Route::currentRouteName() == 'seasons.index' ? 'active' : '' }}"><a href="{{ route('seasons.index') }}">Seasons</a></li>
				</ul>
			</li>
			
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Races <span class="caret"></span></a>
				
				<ul class="dropdown-menu">
					<li class="{{ Route::currentRouteName() == 'races.index' ? 'active' : '' }}"><a href="{{ route('races.index') }}">Races</a></li>
					<li class="{{ Route::currentRouteName() == 'circuits.index' ? 'active' : '' }}"><a href="{{ route('circuits.index') }}">Circuits</a></li>
					
					<li role="separator" class="divider"></li>

					<li class="{{ Route::currentRouteName() == 'countries.index' ? 'active' : '' }}"><a href="{{ route('countries.index') }}">Countries</a></li>
				</ul>
			</li>
			
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Entries <span class="caret"></span></a>
				
				<ul class="dropdown-menu">
					<li class="{{ Route::currentRouteName() == 'entries.index' ? 'active' : '' }}"><a href="{{ route('entries.index') }}">Entries</a></li>
					
					<li role="separator" class="divider"></li>
			
					<li class="{{ Route::currentRouteName() == 'drivers.index' ? 'active' : '' }}"><a href="{{ route('drivers.index') }}">Drivers</a></li>
					<li class="{{ Route::currentRouteName() == 'teams.index' ? 'active' : '' }}"><a href="{{ route('teams.index') }}">Teams</a></li>
					
					<li role="separator" class="divider"></li>

					<li class="{{ Route::currentRouteName() == 'countries.index' ? 'active' : '' }}"><a href="{{ route('countries.index') }}">Countries</a></li>
				</ul>
			</li>
			
			<li class="{{ Route::currentRouteName() == 'results.index' ? 'active' : '' }}"><a href="{{ route('results.index') }}">Results</a></li>
			
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Users <span class="caret"></span></a>
				
				<ul class="dropdown-menu">
					<li class="{{ Route::currentRouteName() == 'users.index' ? 'active' : '' }}"><a href="{{ route('users.index') }}">Users</a></li>
					<li class="{{ Route::currentRouteName() == 'leagues.index' ? 'active' : '' }}"><a href="{{ route('leagues.index') }}">Leagues</a></li>
					
					<li role="separator" class="divider"></li>

					<li class="{{ Route::currentRouteName() == 'userleagues.index' ? 'active' : '' }}"><a href="{{ route('userleagues.index') }}">User's leagues</a></li>
				</ul>
			</li>
			
			<li><a class="warning" href="{{ route('home') }}">Return</a></li>

			<li><a class="danger" href="{{ route('logout') }}">Logout</a></li>
		@endif
	</ul>

	@include('auth.username')
</nav>
