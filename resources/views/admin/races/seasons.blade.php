<div class="btn-group">
	<button class="btn btn-primary dropdown-toggle" type="button" id="seasonDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		{{ $currentSeason->name }} <span class="caret"></span>
	</button>

	<ul class="dropdown-menu" aria-labelledby="seasonDropdown">
	@foreach( $seasons as $season )
		<li class="{{ $currentSeason->id == $season->id ? 'active' : '' }}">
			<a href="{{ route('admin.races.index', [ 'season' => $season->id ] ) }}">{{ $season->name }}</a>
		</li>
	@endforeach
	</ul>
</div>

