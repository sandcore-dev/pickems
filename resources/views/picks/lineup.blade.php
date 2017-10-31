<div class="col-md-9">
@if ($errors->has('entry'))
	<div class="row">
		<div class="col-md-7 col-md-offset-2">
			<p class="text-danger text-center">
				<strong>{{ $errors->first('entry') }}</strong>
			</p>
		</div>
	</div>
@endif

	<form action="{{ route( 'picks.delete', [ 'league' => $currentLeague->id, 'race' => $currentRace->id ] ) }}" method="post">
	{{ csrf_field() }}
	{{ method_field('DELETE') }}
	
	@forelse( $picks as $pick )
		<div class="row">
			<div class="col-md-3 col-md-offset-{{ $pick->rank % 2 == 0 ? 6 : 2 }}">
				<div class="rank text-center">{{ $pick->rank }}</div>
				<div class="bracket">
					@if( $pick->entry )
					<button class="btn btn-primary btn-block" type="submit" name="pick" value="{{ $pick->id }}">
						<span class="first-name">{{ $pick->entry->driver->first_name }}</span>
						<span class="last-name">{{ $pick->entry->driver->last_name }}</span>
					</button>
					@else
						&nbsp;
					@endif
				</div>
			</div>
		</div>
	@empty
		@foreach( range( 1, config('picks.max') ) as $rank )
			<div class="row">
				<div class="col-md-3 col-md-offset-{{ $rank % 2 == 0 ? 6 : 2 }}">
					<div class="rank text-center">{{ $rank }}</div>
					<div class="bracket">
						&nbsp;
					</div>
				</div>
			</div>
		@endforeach
	@endforelse
	</form>
</div>
