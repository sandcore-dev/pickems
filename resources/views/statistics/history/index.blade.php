@extends('layouts.app')

@section('title', 'Historical records - Statistics -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
        	@include('statistics.history.dropdown')

		<table class="table">
		<tr>
			<th>
				Best pickems result
			</th>
			<td>
				<strong>{{ $bestPickems->total }}</strong> ({{ $bestPickems->picked }} + {{ $bestPickems->positions_correct }}) by <strong>{{ $bestPickems->user->name }}</strong> in <strong>{{ $bestPickems->race->season->name }}</strong> at <strong>{{ $bestPickems->race->circuit->name }}, {{ $bestPickems->race->circuit->locationShort }}</strong>
				
			</td>
		</tr>
		</table>
        </div>
    </div>
</div>
@endsection
