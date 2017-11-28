            	<div class="btn-group" role="group">
            		
            		@if( $leagues->count() > 1 )
            		<div class="btn-group">
	            		<button class="btn btn-primary dropdown-toggle" type="button" id="leagueDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	            			{{ $currentLeague->name }} <span class="caret"></span>
	            		</button>
	            		
	            		<ul class="dropdown-menu" aria-labelledby="leagueDropdown">
	            		@foreach( $leagues as $league )
	            			<li class="{{ $currentLeague->id == $league->id ? 'active' : '' }}">
	            				<a href="{{ route('statistics.season', [ 'league' => $league->id ] ) }}">{{ $league->name }}</a>
	            			</li>
	            		@endforeach
	            		</ul>
	            	</div>
	            	@endif
	            	
	            	@if( $currentLeague->series->seasons->count() > 1 )
	            	<div class="btn-group">
	            		<button class="btn btn-primary dropdown-toggle" type="button" id="seasonDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	            			{{ $currentSeason->name }} <span class="caret"></span>
	            		</button>
	            		
	            		<ul class="dropdown-menu" aria-labelledby="seasonDropdown">
	            		@foreach( $currentLeague->series->seasons as $season )
	            			<li class="{{ $currentSeason->id == $season->id ? 'active' : '' }}">
	            				<a href="{{ route('statistics.season', [ 'league' => $currentLeague->id, 'season' => $season->id, 'user' => $currentUser->id ] ) }}">{{ $season->name }}</a>
	            			</li>
	            		@endforeach
	            		</ul>
	            	</div>
	            	@endif

	            	<div class="btn-group">
	            		<button class="btn btn-primary dropdown-toggle" type="button" id="seasonDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	            			{{ $currentUser->name }} <span class="caret"></span>
	            		</button>
	            		
	            		<ul class="dropdown-menu" aria-labelledby="seasonDropdown">
	            		@foreach( $users as $user )
	            			<li class="{{ $currentUser->id == $user->id ? 'active' : '' }}">
	            				<a href="{{ route('statistics.season', [ 'league' => $currentLeague->id, 'season' => $currentSeason->id, 'user' => $user->id ] ) }}">{{ $user->name }}</a>
	            			</li>
	            		@endforeach
	            		</ul>
	            	</div>
	        </div>

