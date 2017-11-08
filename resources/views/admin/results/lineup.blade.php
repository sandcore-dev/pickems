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

	<form action="{{ route( 'results.delete', [ 'race' => $currentRace->id ] ) }}" method="post">
	{{ csrf_field() }}
	{{ method_field('DELETE') }}
	
	@foreach( $results as $result )
		<div class="row">
			<div class="col-md-4 col-md-offset-{{ $result->rank % 2 == 0 ? 7 : 1 }}">
				<div class="rank text-center">{{ $result->rank }}</div>
				<div class="bracket">
					@if( $result->entry )
					<button class="btn btn-primary btn-block" type="submit" name="result" value="{{ $result->id }}">
						<span class="first-name">{{ $result->entry->driver->first_name }}</span>
						<span class="last-name">{{ $result->entry->driver->last_name }}</span>
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
