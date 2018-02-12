<nav class="navbar navbar-default navbar-inverse">
	<div class="container-fluid visible-xs">
		<div class="navbar-header">
			<a href="/" class="navbar-brand">{{ config('app.name', 'Laravel') }} @yield('secondary')</a>

			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false">
				<span class="sr-only">@lang('Toggle navigation')</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			
		</div>
	</div>

	<div class="collapse navbar-collapse" id="menu">
		<ul class="navbar-nav nav">
			@if( Auth::check() )
				<li class="dropdown @routeActive('/^admin\.(series|seasons)\./')">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">@lang('Series') <span class="caret"></span></a>
				
					<ul class="dropdown-menu">
						<li class="@routeActive('/^admin\.series\./')"><a href="{{ route('admin.series.index') }}">@lang('Series')</a></li>
						<li class="@routeActive('/^admin\.seasons\./')"><a href="{{ route('admin.seasons.index') }}">@lang('Seasons')</a></li>
					</ul>
				</li>
			
				<li class="dropdown @routeActive('/^admin\.(races|circuits)\./')">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">@lang('Races') <span class="caret"></span></a>
				
					<ul class="dropdown-menu">
						<li class="@routeActive('/^admin\.races\./')"><a href="{{ route('admin.races.index') }}">@lang('Races')</a></li>
						<li class="@routeActive('/^admin\.circuits\./')"><a href="{{ route('admin.circuits.index') }}">@lang('Circuits')</a></li>
					</ul>
				</li>
			
				<li class="dropdown @routeActive('/^admin\.(entries|drivers|teams|countries)\./')">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">@lang('Entries') <span class="caret"></span></a>
				
					<ul class="dropdown-menu">
						<li class="@routeActive('/^admin\.entries\./')"><a href="{{ route('admin.entries.index') }}">@lang('Entries')</a></li>
					
						<li role="separator" class="divider"></li>
			
						<li class="@routeActive('/^admin\.drivers\./')"><a href="{{ route('admin.drivers.index') }}">@lang('Drivers')</a></li>
						<li class="@routeActive('/^admin\.teams\./')"><a href="{{ route('admin.teams.index') }}">@lang('Teams')</a></li>
					
						<li role="separator" class="divider"></li>

						<li class="@routeActive('/^admin\.countries\./')"><a href="{{ route('admin.countries.index') }}">@lang('Countries')</a></li>
					</ul>
				</li>
			
				<li class="dropdown @routeActive('/^admin\.(results|picks)\./')">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">@lang('Results') <span class="caret"></span></a>
				
					<ul class="dropdown-menu">
						<li class="@routeActive('/^admin\.results\./')"><a href="{{ route('admin.results.index') }}">@lang('Results')</a></li>
						<li class="@routeActive('/^admin\.picks\./')"><a href="{{ route('admin.picks.index') }}">@lang('Picks')</a></li>
					</ul>
				</li>
			
				<li class="dropdown @routeActive('/^admin\.(users|leagues|userleagues)\./')">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">@lang('Users') <span class="caret"></span></a>
				
					<ul class="dropdown-menu">
						<li class="@routeActive('/^admin\.users\./')"><a href="{{ route('admin.users.index') }}">@lang('Users')</a></li>
						<li class="@routeActive('/^admin\.leagues\./')"><a href="{{ route('admin.leagues.index') }}">@lang('Leagues')</a></li>
					
						<li role="separator" class="divider"></li>

						<li class="@routeActive('/^admin\.userleagues\./')"><a href="{{ route('admin.userleagues.index') }}">@lang("User's leagues")</a></li>
					</ul>
				</li>
			
				<li><a class="warning" href="{{ route('picks') }}">@lang('Return')</a></li>

				<li><a class="danger" href="{{ route('logout') }}">@lang('Logout')</a></li>
			@endif
		</ul>

		@include('auth.username')
	</div>
</nav>
