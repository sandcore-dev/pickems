<div class="col-md-9">
@forelse( auth()->user()->picks->getByRace($currentRace) as $pick )
	<div class="row">
		<div class="col-md-3 col-md-offset-{{ $pick->rank % 2 == 0 ? 6 : 2 }}">
			<div class="rank text-center">{{ $pick->rank }}</div>
			<div class="bracket">
				<button class="btn btn-primary btn-block">
					<span class="first-name">{{ $pick->entry->driver->first_name }}</span>
					<span class="last-name">{{ $pick->entry->driver->last_name }}</span>
				</button>
			</div>
		</div>
	</div>
@empty
	@foreach( range( 1, 10 ) as $rank )
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
</div>
