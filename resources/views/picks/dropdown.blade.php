            	<div class="btn-group" role="group">
            		
            		@if( $leagues->count() > 1 )
            		<div class="btn-group">
	            		<button class="btn btn-primary dropdown-toggle" type="button" id="leagueDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	            			{{ $currentLeague->name }} <span class="caret"></span>
	            		</button>
	            		
	            		<ul class="dropdown-menu" aria-labelledby="leagueDropdown">
	            		@foreach( $leagues as $league )
	            			<li class="{{ $currentLeague->id == $league->id ? 'active' : '' }}">
	            				<a href="{{ route('picks.league', [ 'league' => $league->id ] ) }}">{{ $league->name }}</a>
	            			</li>
	            		@endforeach
	            		</ul>
	            	</div>
	            	@endif
	            	
	            	@if( $currentLeague->seasons->count() > 1 )
	            	<div class="btn-group">
	            		<button class="btn btn-primary dropdown-toggle" type="button" id="seasonDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	            			{{ $currentRace->season->name }} <span class="caret"></span>
	            		</button>
	            		
	            		<ul class="dropdown-menu" aria-labelledby="seasonDropdown">
	            		@foreach( $currentLeague->seasons as $season )
	            			<li class="{{ $currentRace->season->id == $season->id ? 'active' : '' }}">
	            				<a href="{{ route('picks.season', [ 'league' => $currentLeague->id, 'season' => $season->id ] ) }}">{{ $season->name }}</a>
	            			</li>
	            		@endforeach
	            		</ul>
	            	</div>
	            	@endif

	            	<div class="btn-group">
	            		<button class="btn btn-primary dropdown-toggle" type="button" id="raceDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	            			<span class="flag-icon flag-icon-{{ strtolower( $currentRace->circuit->country->code ) }}"></span>
	            			{{ $currentRace->circuit->country->name }} <span class="caret"></span>
	            		</button>
	            		
	            		<ul class="dropdown-menu" aria-labelledby="raceDropdown">
	            		@foreach( $currentRace->season->races as $race )
	            			<li class="{{ $currentRace->id == $race->id ? 'active' : '' }}">
	            				<a href="{{ route('picks.race', [ 'league' => $currentLeague->id, 'race' => $race->id ] ) }}">
	            					<span class="flag-icon flag-icon-{{ strtolower( $race->circuit->country->code ) }}"></span>
	            					{{ $race->circuit->country->name }}
	            				</a>
	            			</li>
	            		@endforeach
	            		</ul>
	            	</div>
	            	
	        </div>

