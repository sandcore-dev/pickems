						<span class="pull-left">
							<span class="first-name hidden-sm">{{ $entry->driver->first_name }}</span>
						
							<span class="first-letter visible-sm-inline">{{ $entry->driver->first_letter }}</span>
						
							<span class="last-name">{{ $entry->driver->last_name }}</span>
						</span>
						
						<span class="abbreviation visible-xs-inline">{{ $entry->abbreviation }}</span>
						
						@if( $entry->driver->country )
							<span class="pull-right">
								<span class="{{ $entry->driver->country->flagClass }}"></span>
							</span>
						@endif

