@extends('layouts.app')

@section('title', __('All-time rankings') . ' - ' . __('Statistics') . ' -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
        	@include('statistics.alltime.dropdown')

		<h3>@lang('All-time rankings (minimum 5 seasons)')</h3>
		<table class="table table-striped">
		<thead>
			<tr>
				<th class="col-xs-3">@lang('Name')</th>
				<th class="col-xs-3 text-right">@lang('Average final ranking')</th>
				<th class="col-xs-3 text-right hidden-xs">@lang('Highest')</th>
				<th class="col-xs-3 text-right hidden-xs">@lang('Lowest')</th>
			</tr>
		</thead>
		<tbody>
			@forelse( $averages as $average )
				<tr>
					<td>{{ $average->first()->user->name }}</td>
					<td class="text-right">{{ sprintf('%.02f', $average->avg('rank')) }}</td>
					<td class="text-right hidden-xs">{{ $average->min('rank') }}</td>
					<td class="text-right hidden-xs">{{ $average->max('rank') }}</td>
				</tr>
			@empty
				<tr>
					<td colspan="4">@lang('Standings probably have not been built yet.')</td>
				</tr>
			@endforelse
		</tbody>
		</table>
        </div>
    </div>
</div>
@endsection
