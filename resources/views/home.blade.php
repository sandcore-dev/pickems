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
        		
        		@if( $bestresult = $league->currentSeasonBestResult )
        			<p>Your best result this season was <strong>{{ $bestresult->total }}</strong> point(s) at the <strong>{{ $bestresult->race->name }}</strong>.</p>
        		@endif
        	@endforeach
        </div>
    </div>
</div>
@endsection
