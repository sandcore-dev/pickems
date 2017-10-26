<div class="col-md-9">
@foreach( $currentRace->picks->where('user.id', auth()->user()->id )->sortBy('rank') as $pick )
	<div class="row">
		<div class="col-md-3 col-md-offset-{{ $pick->rank % 2 == 0 ? 6 : 2 }}">
			<div class="rank text-center">{{ $pick->rank }}</div>
			<button class="btn btn-default btn-block"">
				<span class="first-name">{{ $pick->entry->driver->first_name }}</span>
				<span class="last-name">{{ $pick->entry->driver->last_name }}</span>
			</button>
		</div>
	</div>
@endforeach
</div>
