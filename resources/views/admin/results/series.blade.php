<div class="btn-group">
	<button class="btn btn-primary dropdown-toggle" type="button" id="serieDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		{{ $currentSeries->name }} <span class="caret"></span>
	</button>

	<ul class="dropdown-menu" aria-labelledby="serieDropdown">
	@foreach( $series as $serie )
		<li class="{{ $currentSeries->id == $serie->id ? 'active' : '' }}">
			<a href="{{ route('results.index', [ 'series' => $serie->id ] ) }}">{{ $serie->name }}</a>
		</li>
	@endforeach
	</ul>
</div>

