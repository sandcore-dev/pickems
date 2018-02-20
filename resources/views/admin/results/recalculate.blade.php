@if( $showRecalcBut )
<div class="btn-group pull-right">
	<a class="btn btn-danger" href="{{ route('admin.standings.recalculate', [ 'season' => $currentSeason->id ] ) }}">@lang('Recalculate standings')</a>
</div>
@endif
