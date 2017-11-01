@if( Auth::check() )
	<p class="navbar-text pull-right">Logged in as <a href="{{ route('profile') }}">{{ Auth::user()->name }}</a></p>
@endif
