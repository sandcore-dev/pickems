<div class="col-xs-3">
	@if( $currentRace->weekend_start->gte( \Carbon\Carbon::now() ) )
		<form class="btn-group-vertical btn-block drivers" role="group" aria-label="Drivers" method="post" action="{{ route( 'picks.create', [ 'league' => $currentLeague->id, 'race' => $currentRace->id ] ) }}">
			{{ csrf_field() }}
	
			@foreach( $entriesByTeam as $entries )
				@foreach( $entries as $entry )
					<button class="btn btn-default team-color" style="border-left-color: {{ $entry->color }}" draggable="true" type="submit" name="entry" value="{{ $entry->id }}">
						@include('common.entry')
					</button>
				@endforeach
			@endforeach
		</form>
	@elseif($picks->first()->carry_over)
		<p class="alert alert-warning">
			These picks carried over from the previous race.
		</p>
	@endunless
</div>
