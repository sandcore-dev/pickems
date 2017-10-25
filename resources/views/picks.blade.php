@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            
            	<div class="btn-group" role="group">
            		
            		@if( $leagues->count() > 1 )
            		<div class="btn-group">
	            		<button class="btn btn-default dropdown-toggle" type="button" id="leagueDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	            			{{ $currentLeague->name }} <span class="caret"></span>
	            		</button>
	            		
	            		<ul class="dropdown-menu" aria-labelledby="leagueDropdown">
	            		@foreach( $leagues as $league )
	            			<li class="{{ $currentLeague->id == $league->id ? 'active' : '' }}">
	            				<a href="{{ route('picks', [ 'leagueId' => $league->id ] ) }}">{{ $league->name }}</a>
	            			</li>
	            		@endforeach
	            		</ul>
	            	</div>
	            	@endif
	            	
	            	@if( $seasons->count() > 1 )
	            	<div class="btn-group">
	            		<button class="btn btn-default dropdown-toggle" type="button" id="seasonDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	            			{{ $currentSeason->name }} <span class="caret"></span>
	            		</button>
	            		
	            		<ul class="dropdown-menu" aria-labelledby="seasonDropdown">
	            		@foreach( $seasons as $season )
	            			<li class="{{ $currentSeason->id == $season->id ? 'active' : '' }}">
	            				<a href="{{ route('picks', [ 'leagueId' => $currentLeague->id, 'seasonId' => $season->id ] ) }}">{{ $season->name }}</a>
	            			</li>
	            		@endforeach
	            		</ul>
	            	</div>
	            	@endif

	            	<div class="btn-group">
	            		<button class="btn btn-default dropdown-toggle" type="button" id="raceDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	            			<span class="flag-icon flag-icon-{{ strtolower( $currentRace->circuit->country->code ) }}"></span>
	            			{{ $currentRace->circuit->country->name }} <span class="caret"></span>
	            		</button>
	            		
	            		<ul class="dropdown-menu" aria-labelledby="raceDropdown">
	            		@foreach( $races as $race )
	            			<li class="{{ $currentRace->id == $race->id ? 'active' : '' }}">
	            				<a href="{{ route('picks', [ 'leagueId' => $currentLeague->id, 'seasonId' => $currentSeason->id, 'raceId' => $race->id ] ) }}">
	            					<span class="flag-icon flag-icon-{{ strtolower( $race->circuit->country->code ) }}"></span>
	            					{{ $race->circuit->country->name }}
	            				</a>
	            			</li>
	            		@endforeach
	            		</ul>
	            	</div>
	            	
	        </div>
    
        </div>
    </div>
</div>
@endsection
