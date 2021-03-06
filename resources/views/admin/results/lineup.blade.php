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

	<form action="{{ route( 'admin.results.delete', [ 'race' => $currentRace->id ] ) }}" method="post">
	{{ csrf_field() }}
	{{ method_field('DELETE') }}
	
	@foreach( $results as $result )
		<div class="row">
			<div class="col-xs-5 col-lg-4 col-xs-offset-{{ $result->rank % 2 == 0 ? 7 : 1 }}">
				<div class="rank text-center">{{ $result->rank }}</div>
				<div class="bracket">
					@if( $result->entry )
					<button class="btn btn-primary btn-block team-color" style="border-left-color: {{ $result->entry->color }}" type="submit" name="result" value="{{ $result->id }}">
						@include( 'common.entry', [ 'entry' => $result->entry, 'showDetails' => true ] )
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
