<div class="btn-group">
	<button class="btn btn-primary dropdown-toggle" type="button" id="raceDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		<span class="flag-icon flag-icon-{{ strtolower( $currentRace->circuit->country->code ) }}"></span>
		{{ $currentRace->circuit->country->name }} <span class="caret"></span>
	</button>

	<ul class="dropdown-menu" aria-labelledby="raceDropdown">
	@foreach( $races as $race )
		<li class="{{ $currentRace->id == $race->id ? 'active' : '' }}">
			<a href="{{ route('admin.picks.index', [ 'race' => $race->id ] ) }}">
				<span class="flag-icon flag-icon-{{ strtolower( $race->circuit->country->code ) }}"></span>
				{{ $race->circuit->country->name }}
			</a>
		</li>
	@endforeach
	</ul>
</div>

