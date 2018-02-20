<div class="btn-group">
	<button class="btn btn-primary dropdown-toggle" type="button" id="raceDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		<span class="{{ $currentRace->circuit->country->flagClass }}"></span>
		{{ $currentRace->circuit->country->localName }} <span class="caret"></span>
	</button>

	<ul class="dropdown-menu" aria-labelledby="raceDropdown">
	@foreach( $races as $race )
		<li class="{{ $currentRace->id == $race->id ? 'active' : '' }}">
			<a href="{{ route('admin.picks.index', [ 'race' => $race->id ] ) }}">
				<span class="{{ $race->circuit->country->flagClass }}"></span>
				{{ $race->circuit->country->localName }}
			</a>
		</li>
	@endforeach
	</ul>
</div>

