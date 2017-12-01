@extends('layouts.app')

@section('title', 'Season performance - Statistics -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
        	@include('statistics.season.dropdown')

		<div class="vue">
        		<user-league-results data-series="{{ App\Standing::with(['league.users', 'race.circuit.country'])->byLeague($currentLeague)->bySeason($currentSeason)->byUser($currentUser)->get()->getChartData() }}"></user-league-results>
		</div>
        </div>
    </div>
</div>
@endsection
