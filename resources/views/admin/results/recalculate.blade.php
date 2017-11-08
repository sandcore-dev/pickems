@if( $showRecalcBut )
<div class="btn-group pull-right">
	<a class="btn btn-danger" href="{{ route('standings.recalculate', [ 'season' => $currentSeason->id ] ) }}">Recalculate standings</a>
</div>
@endif
