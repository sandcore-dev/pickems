@if( Auth::check() )
	<p class="navbar-text pull-right hidden-xs hidden-sm">Logged in as <a href="{{ route('profile') }}">{{ Auth::user()->name }}</a></p>
@endif
