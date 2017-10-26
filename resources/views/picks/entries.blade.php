<div class="col-md-3">
	@if( $currentRace->weekend_start->gte( \Carbon\Carbon::now() ) )
	
	<form class="btn-group-vertical drivers" role="group" aria-label="Drivers" method="post" action="{{ route( 'picks', [ 'leagueId' => $currentLeague->id, 'seasonId' => $currentSeason->id, 'raceId' => $currentRace->id ] ) }}">
	
	@foreach( $currentSeason->entries->getByTeam() as $entries )
		@foreach( $entries as $entry )
			<button class="btn btn-default" draggable="true" type="submit" name="driver" value="{{ $entry->id }}">
				<span class="first-name">{{ $entry->driver->first_name }}</span>
				<span class="last-name">{{ $entry->driver->last_name }}</span>
			</button>
		@endforeach
	@endforeach
	
	</form>
	
	@endunless
</div>
