@extends('layouts.app')

@section('title', __('Hall of Fame') . ' - ' . __('Statistics') . ' -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
        	@include('statistics.fame.dropdown')

		<h3>@lang('Hall of Fame')</h3>
		<table class="table table-striped">
		<thead>
			<tr>
				<th class="col-xs-4">@lang('Name')</th>
				<th class="col-xs-3">@lang('Championships')</th>
			</tr>
		</thead>
		<tbody>
			@forelse( $champions as $champion )
				<tr>
					<td>{{ $champion->first()->user->name }}</td>
					<td>{{ implode( ', ', $champion->pluck('race.season.name')->toArray() ) }}</td>
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
