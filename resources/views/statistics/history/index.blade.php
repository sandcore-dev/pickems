@extends('layouts.app')

@section('title', 'Historical records - Statistics -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
        	@include('statistics.history.dropdown')

		<h3>Best pickems</h3>
		<table class="table table-striped">
		<thead>
			<tr>
				<th class="col-xs-4">Name</th>
				<th class="col-xs-2">Points</th>
				<th class="col-xs-2">Season</th>
				<th class="col-xs-4">Race</th>
			</tr>
		</thead>
		<tbody>
			@forelse( $bestPickems as $pickems )
				<tr>
					<td>{{ $pickems->user->name }}</td>
					<td>{{ $pickems->total }} ({{ $pickems->picked }} + {{ $pickems->positions_correct }})</td>
					<td>{{ $pickems->race->season->name }}</td>
					<td>{{ $pickems->race->circuit->locationShort }}</td>
				</tr>
			@empty
				<tr>
					<td colspan="4">Standings probably have not been built yet.</td>
				</tr>
			@endforelse
		</tbody>
		</table>

		<h3>Best carry-over pickems</h3>
		<table class="table table-striped">
		<thead>
			<tr>
				<th class="col-xs-4">Name</th>
				<th class="col-xs-2">Points</th>
				<th class="col-xs-2">Season</th>
				<th class="col-xs-4">Race</th>
			</tr>
		</thead>
		<tbody>
			@forelse( $bestCarryover as $pickems )
				<tr>
					<td>{{ $pickems->user->name }}</td>
					<td>{{ $pickems->total }} ({{ $pickems->picked }} + {{ $pickems->positions_correct }})</td>
					<td>{{ $pickems->race->season->name }}</td>
					<td>{{ $pickems->race->circuit->locationShort }}</td>
				</tr>
			@empty
				<tr>
					<td colspan="4">Standings probably have not been built yet.</td>
				</tr>
			@endforelse
		</tbody>
		</table>

		<h3>Highest points total in a season</h3>
		<table class="table table-striped">
		<thead>
			<tr>
				<th class="col-xs-4">Name</th>
				<th class="col-xs-2">Points</th>
				<th class="col-xs-2">Season</th>
				<th class="col-xs-4">Race</th>
			</tr>
		</thead>
		<tbody>
			@forelse( $highestPoints as $pickems )
				<tr>
					<td>{{ $pickems->user->name }}</td>
					<td>{{ $pickems->total_overall }} ({{ $pickems->total_picked }} + {{ $pickems->total_positions_correct }})</td>
					<td>{{ $pickems->race->season->name }}</td>
					<td>{{ $pickems->race->circuit->locationShort }}</td>
				</tr>
			@empty
				<tr>
					<td colspan="4">Standings probably have not been built yet.</td>
				</tr>
			@endforelse
		</tbody>
		</table>
        </div>
    </div>
</div>
@endsection
