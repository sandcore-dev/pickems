<div class="col-md-3">
	@if( $currentRace->weekend_start->gte( \Carbon\Carbon::now() ) )
	
	<form class="btn-group-vertical" role="group" aria-label="Drivers">
	
	@foreach( $currentSeason->entries()->active()->sortByTeamDriver()->get() as $entry )
		<a class="text-left btn btn-default" draggable="true" href="#">
			{{ $entry->driver->first_name }}
			{{ $entry->driver->last_name }}
		</a>
	@endforeach
	
	</form>
	
	@endunless
</div>
