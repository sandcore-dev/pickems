<div class="col-md-3">
	@if( $currentRace->weekend_start->lte( \Carbon\Carbon::now() ) )
		<form class="btn-group-vertical btn-block drivers" role="group" aria-label="Drivers" method="post" action="{{ route( 'results.create', [ 'race' => $currentRace->id ] ) }}">
			{{ csrf_field() }}
	
			@foreach( $entriesByTeam as $entries )
				@foreach( $entries as $entry )
					<button class="btn btn-default" draggable="true" type="submit" name="entry" value="{{ $entry->id }}">
						<span class="first-name">{{ $entry->driver->first_name }}</span>
						<span class="last-name">{{ $entry->driver->last_name }}</span>
					</button>
				@endforeach
			@endforeach
		</form>
	@endunless
</div>
