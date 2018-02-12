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
			@if( !Auth::check() )
				<li class="@routeActive('/^login$/')"><a href="{{ route('login') }}">@lang('Login')</a></li>
			@else
				<li class="@routeActive('/^profile$/')" ><a href="{{ route('profile') }}">@lang('Profile')</a></li>
				<li class="@routeActive('/^picks/')" ><a href="{{ route('picks') }}">@lang('Picks')</a></li>
				<li class="@routeActive('/^standings/')" ><a href="{{ route('standings') }}">@lang('Standings')</a></li>

				<li class="dropdown @routeActive('/^statistics\./')">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">@lang('Statistics') <span class="caret"></span></a>
				
					<ul class="dropdown-menu">
						<li class="@routeActive('/^statistics\.season$/') hidden-xs"><a href="{{ route('statistics.season') }}">@lang('Season performance')</a></li>
						<li class="@routeActive('/^statistics\.history$/')"><a href="{{ route('statistics.history') }}">@lang('Historical records')</a></li>
						<li class="@routeActive('/^statistics\.alltime$/')"><a href="{{ route('statistics.alltime') }}">@lang('All-time rankings')</a></li>
						<li class="@routeActive('/^statistics\.fame$/')"><a href="{{ route('statistics.fame') }}">@lang('Hall of Fame')</a></li>
					</ul>
				</li>

				@if( Gate::allows('admin') )
					<li><a class="warning" href="{{ route('admin.results.index') }}">@lang('Admin')</a></li>
				@endif

				<li><a class="danger" href="{{ route('logout') }}">@lang('Logout')</a></li>
			@endif
		</ul>
	
		@include('auth.username')
	</div>
</nav>
