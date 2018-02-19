<div class="container">
    <div class="row">
        <div class="col-md-12">

	<table class="table table-striped table-hover">
    		<thead>
    			<tr class="hidden-xs">
    				<th colspan="3">
    					&nbsp;
    				</th>
    				<th class="text-right">
    					@lang('Overall')
    				</th>
    				<th colspan="2">
    					&nbsp;
    				</th>
    				<th class="text-right">
    					@lang('Race')
    				</th>
    				<th colspan="2">
    					&nbsp;
    				</th>
    			</tr>
    			<tr>
    				<th class="text-right">
    					<span class="hidden-xs hidden-sm">
							@lang('Rank')
						</span>
    				</th>
    				<th class="hidden-xs">
    					&nbsp;
    				</th>
    				<th>
    					@lang('Name')
    				</th>
    				<th class="text-right">
    					@lang('Total')
    				</th>
    				<th class="text-right">
    					@lang('Finish')
    				</th>
    				<th class="text-right">
    					@lang('Top :number', [ 'number' => $standings->count() ? $standings->first()->race->season->picks_max : config('picks.max') ])
    				</th>
    				<th class="text-right hidden-xs">
    					@lang('Total')
    				</th>
    				<th class="text-right hidden-xs">
    					@lang('Finish')
    				</th>
    				<th class="text-right hidden-xs">
    					@lang('Top :number', [ 'number' => $standings->count() ? $standings->first()->race->season->picks_max : config('picks.max') ])
    				</th>
    			</tr>
    		</thead>
    		<tbody>
    		<?php $previous_rank = 0; ?>
    		@forelse( $standings as $standing )
    			<tr>
    				<td class="text-right">
    					@if( $previous_rank != $standing->rank )
							{{ $standing->rank }}
    					@endif
    					<?php $previous_rank = $standing->rank; ?>
    				</td>
    				<td class="text-right hidden-xs">
    					<span class="hidden-sm">{{ $standing->rankMoved }}</span>
    					<span class="glyphicon {{ $standing->rankMovedGlyphicon }}"></span>
    				</td>
    				<td>
    					{{ $standing->user->name }}
    				</td>
    				<td class="text-right">
    					{{ $standing->total_overall }}
    				</td>
    				<td class="text-right">
    					{{ $standing->total_positions_correct }}
    				</td>
    				<td class="text-right">
    					{{ $standing->total_picked }}
    				</td>
    				<td class="text-right hidden-xs">
    					{{ $standing->total }}
    				</td>
    				<td class="text-right hidden-xs">
    					{{ $standing->positions_correct }}
    				</td>
    				<td class="text-right hidden-xs">
    					{{ $standing->picked }}
    				</td>
    			</tr>
    		@empty
    			<tr>
    				<td colspan="9" class="text-center">
    					@lang('No standings found for this race.')
    				</td>
    			</tr>
    		@endforelse
    		</tbody>
	</table>

        </div>
    </div>
</div>

