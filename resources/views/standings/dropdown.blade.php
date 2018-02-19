            	<div class="btn-group" role="group">
            		
            		@if( $leagues->count() > 1 )
            		<div class="btn-group">
	            		<button class="btn btn-primary dropdown-toggle" type="button" id="leagueDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	            			{{ $currentLeague->name }} <span class="caret"></span>
	            		</button>
	            		
	            		<ul class="dropdown-menu" aria-labelledby="leagueDropdown">
	            		@foreach( $leagues as $league )
	            			<li class="{{ $currentLeague->id == $league->id ? 'active' : '' }}">
	            				<a href="{{ route('standings.league', [ 'league' => $league->id ] ) }}">{{ $league->name }}</a>
	            			</li>
	            		@endforeach
	            		</ul>
	            	</div>
	            	@endif
	            	
	            	@if( $currentLeague->series->seasons->count() > 1 )
	            	<div class="btn-group">
	            		<button class="btn btn-primary dropdown-toggle" type="button" id="seasonDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	            			{{ $currentRace->season->name }} <span class="caret"></span>
	            		</button>
	            		
	            		<ul class="dropdown-menu" aria-labelledby="seasonDropdown">
	            		@foreach( $currentLeague->series->seasons as $season )
	            			<li class="{{ $currentRace->season->id == $season->id ? 'active' : '' }}">
	            				<a href="{{ route('standings.season', [ 'league' => $currentLeague->id, 'season' => $season->id ] ) }}">{{ $season->name }}</a>
	            			</li>
	            		@endforeach
	            		</ul>
	            	</div>
	            	@endif

	            	<div class="btn-group">
	            		<button class="btn btn-primary dropdown-toggle" type="button" id="raceDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	            			<span class="{{ $currentRace->circuit->country->flagClass }}"></span>
	            			{{ $currentRace->circuit->country->localName }} <span class="caret"></span>
	            		</button>
	            		
	            		<ul class="dropdown-menu" aria-labelledby="raceDropdown">
	            		@foreach( $currentRace->season->races()->with('circuit.country')->has('standings')->get() as $race )
	            			<li class="{{ $currentRace->id == $race->id ? 'active' : '' }}">
	            				<a href="{{ route('standings.race', [ 'league' => $currentLeague->id, 'race' => $race->id ] ) }}">
	            					<span class="{{ $race->circuit->country->flagClass }}"></span>
	            					{{ $race->circuit->country->localName }}
	            				</a>
	            			</li>
	            		@endforeach
	            		</ul>
	            	</div>
	            	
	        </div>

