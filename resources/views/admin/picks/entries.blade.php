@if( $currentRace->weekend_start->lte( \Carbon\Carbon::now() ) and !$picks->first()->carry_over )
	<div class="col-xs-3">
		<form class="btn-group-vertical btn-block drivers" role="group" aria-label="Drivers" method="post" action="{{ route( 'admin.picks.create', [ 'race' => $currentRace->id, 'user' => $currentUser->id ] ) }}">
			{{ csrf_field() }}
	
			@foreach( $entriesByTeam as $entries )
				@foreach( $entries as $entry )
					<button class="btn btn-default team-color" style="border-left-color: {{ $entry->color }}" draggable="true" type="submit" name="entry" value="{{ $entry->id }}">
						@include('common.entry')
					</button>
				@endforeach
			@endforeach
		</form>
	</div>
@elseif( $picks->first()->carry_over )
	<div class="col-xs-12 col-sm-3">
		<p class="alert alert-warning">
			@lang('These picks carried over from the previous race.')
		</p>
	</div>
	<div class="col-xs-1 visible-xs-block"></div>
@endunless

