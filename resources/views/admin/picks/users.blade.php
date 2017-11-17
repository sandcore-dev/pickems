<div class="btn-group">
	<button class="btn btn-primary dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		{{ $currentUser->name }} <span class="caret"></span>
	</button>

	<ul class="dropdown-menu" aria-labelledby="userDropdown">
	@foreach( $users as $user )
		<li class="{{ $currentUser->id == $user->id ? 'active' : '' }}">
			<a href="{{ route('admin.picks.index', [ 'race' => $currentRace->id, 'league' => $currentLeague->id, 'user' => $user->id ] ) }}">
				{{ $user->name }}
			</a>
		</li>
	@endforeach
	</ul>
</div>

