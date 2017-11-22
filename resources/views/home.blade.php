@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        	<p>Hello, <strong>{{ $user->name }}</strong>!</p>
        	
        	@foreach( $user->leagues as $league )
        		@if( $user->leagues->count() > 1 )
        			<h2>{{ $league->name }}</h2>
        		@endif
        		
        		@if( $deadline = $league->nextDeadline )
	        		<p>Your next pickems deadline is <strong>{{ $deadline->weekend_start->format('F d, Y H:i T') }}</strong>.</p>
        		@endif
        		
        		<div class="vue">
	        		<user-league-results data-series="{{ App\Standing::byUser($user)->byLeague($league)->get()->getChartData() }}"></user-league-results>
        		</div>
        	@endforeach
        </div>
    </div>
</div>
@endsection
