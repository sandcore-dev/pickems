<div class="col-xs-9">
@if ($errors->has('entry'))
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1">
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
			<div class="col-xs-4 col-xs-offset-{{ $pick->rank % 2 == 0 ? 7 : 1 }}">
				<div class="rank text-center">{{ $pick->rank }}</div>
				<div class="bracket">
					@if( $pick->entry )
					<button class="btn btn-primary btn-block team-color" style="border-left-color: {{ $pick->entry->color }}" type="submit" name="pick" value="{{ $pick->id }}">
						<span class="hidden-xs">
							<span class="first-name hidden-sm">{{ $pick->entry->driver->first_name }}</span>
							<span class="first-letter visible-sm-inline">{{ $pick->entry->driver->first_letter }}</span>
							<span class="last-name">{{ $pick->entry->driver->last_name }}</span>
						</span>
						<span class="abbreviation visible-xs-inline">{{ $pick->entry->abbreviation }}</span>
						
						@if( !is_null( $pick->points ) )
						<span class="badge">{{ $pick->points }} pt</span>
						@endif
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
