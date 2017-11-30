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
			<div class="col-xs-5 col-lg-4 col-xs-offset-{{ $pick->rank % 2 == 0 ? 7 : 1 }}">
				<div class="rank text-center">{{ $pick->rank }}</div>
				<div class="bracket">
					@if( $pick->entry )
					<button class="btn btn-primary btn-block team-color" style="border-left-color: {{ $pick->entry->color }}" type="submit" name="pick" value="{{ $pick->id }}">
						@include( 'common.entry', [ 'entry' => $pick->entry, 'showDetails' => true ] )
						
						@if( $pick->points )
						<span class="pull-right badge hidden-xs hidden-sm">
							{{ $pick->points }} pt
						</span>
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
