						<span class="pull-left">
							<span class="hidden-xs">
								<span class="first-name hidden-sm hidden-md">{{ $entry->driver->first_name }}</span>
						
								<span class="first-letter visible-sm-inline visible-md-inline">{{ $entry->driver->first_letter }}</span>
						
								<span class="last-name">{{ $entry->driver->last_name }}</span>
							</span>
						</span>
						
						<span class="abbreviation visible-xs-inline">{{ $entry->abbreviation }}</span>
						
						@if( $entry->driver->country )
							<span class="pull-right hidden-xs hidden-sm">
								<span class="{{ $entry->driver->country->flagClass }}"></span>
							</span>
						@endif

						@if( isset($showDetails) and $showDetails )
						<br>
						<span class="pull-left details hidden-xs hidden-sm">
							#{{ $entry->car_number }} {{ $entry->team->name }}
						</span>
						@endif

