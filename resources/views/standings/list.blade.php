<div class="container">
    <div class="row">
        <div class="col-md-12">

	<table class="table table-striped table-hover table-responsive">
    		<thead>
    			<tr>
    				<th colspan="3">
    					&nbsp;
    				</th>
    				<th class="text-right">
    					Overall
    				</th>
    				<th colspan="2">
    					&nbsp;
    				</th>
    				<th class="text-right">
    					Race
    				</th>
    				<th colspan="2">
    					&nbsp;
    				</th>
    			</tr>
    			<tr>
    				<th class="text-right">
    					Rank
    				</th>
    				<th>
    					&nbsp;
    				</th>
    				<th>
    					Name
    				</th>
    				<th class="text-right">
    					Total
    				</th>
    				<th class="text-right">
    					Finish
    				</th>
    				<th class="text-right">
    					Top {{ config('picks.max') }}
    				</th>
    				<th class="text-right">
    					Total
    				</th>
    				<th class="text-right">
    					Finish
    				</th>
    				<th class="text-right">
    					Top {{ config('picks.max') }}
    				</th>
    			</tr>
    		</thead>
    		<tbody>
    		@forelse( $standings as $standing )
    			<tr>
    				<td class="text-right">
    					{{ $standing->rank }}
    				</td>
    				<td class="text-right">
    					{{ $standing->rankMoved }}
    					<span class="glyphicon {{ $standing->rankMovedGlyphicon }}"></span>
    				</td>
    				<td>
    					{{ $standing->user->name }}
    				</td>
    				<td class="text-right">
    					{{ $standing->totalOverall }}
    				</td>
    				<td class="text-right">
    					{{ $standing->totalPositionsCorrect }}
    				</td>
    				<td class="text-right">
    					{{ $standing->totalPicked }}
    				</td>
    				<td class="text-right">
    					{{ $standing->total }}
    				</td>
    				<td class="text-right">
    					{{ $standing->positions_correct }}
    				</td>
    				<td class="text-right">
    					{{ $standing->picked }}
    				</td>
    			</tr>
    		@empty
    			<tr>
    				<td colspan="9" class="text-center">
    					No standings found for this race.
    				</td>
    			</tr>
    		@endforelse
    		</tbody>
	</table>

        </div>
    </div>
</div>

