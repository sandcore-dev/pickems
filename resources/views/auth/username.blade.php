@if( Auth::check() )
	<p class="navbar-text pull-right hidden-xs hidden-sm">@lang('Logged in as :name', [ 'name' => '<a href="' . route('profile') . '">' . Auth::user()->name . '</a>' ])</p>
@endif
