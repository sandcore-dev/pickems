@extends('layouts.app')

@section('title', __('Season performance') . ' - ' . __('Statistics') . ' -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
        	@include('statistics.season.dropdown')

		<div class="vue">
        		<user-league-results data-series="{{ $chartData }}"></user-league-results>
		</div>
        </div>
    </div>
</div>
@endsection
