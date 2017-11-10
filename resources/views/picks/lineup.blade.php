<div class="col-md-9">
@if ($errors->has('entry'))
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<p class="text-danger text-center">
				<strong>{{ $errors->first('entry') }}</strong>
			</p>
		</div>
	</div>
@endif

	<form action="{{ route( 'picks.delete', [ 'league' => $currentLeague->id, 'race' => $currentRace->id ] ) }}" method="post">
	{{ csrf_field() }}
	{{ method_field('DELETE') }}
	
	@foreach( $picks as $pick )
		<div class="row">
			<div class="col-md-4 col-md-offset-{{ $pick->rank % 2 == 0 ? 7 : 1 }}">
				<div class="rank text-center">{{ $pick->rank }}</div>
				<div class="bracket">
					@if( $pick->entry )
					<button class="btn btn-primary btn-block team-color" style="border-left-color: {{ $pick->entry->color }}" type="submit" name="pick" value="{{ $pick->id }}">
						<span class="first-name">{{ $pick->entry->driver->first_name }}</span>
						<span class="last-name">{{ $pick->entry->driver->last_name }}</span>
					</button>
					@else
						&nbsp;
					@endif
				</div>
			</div>
		</div>
	@endforeach
	</form>
</div>
