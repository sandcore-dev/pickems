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

	        </div>

