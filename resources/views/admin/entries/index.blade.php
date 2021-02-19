@extends('admin.index')

@section('title', __('Entries') . ' - ' . __('Admin') . ' -')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				@include('admin.entries.series')
				@include('admin.entries.seasons')

				@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif

				<div class="text-center">
					{{ $entries->links() }}
				</div>

				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>
								@lang('Car number')
							</th>
							<th>
								@lang('Team')
							</th>
							<th>
								@lang('Driver')
							</th>
							<th>
								@lang('Abbreviation')
							</th>
							<th>
								@lang('Active')
							</th>
							<th colspan="2" class="text-center">
								<a href="{{ route( 'admin.entries.create', [ 'entry' => $currentSeason->id ] ) }}" title="@lang('Add an entry')" class="glyphicon glyphicon-plus"></a>
							</th>
						</tr>
					</thead>
					<tbody>
						@forelse( $entries as $entry )
							<tr>
								<td>
									<a href="{{ route( 'admin.entries.edit', [ 'entry' => $entry->id ] ) }}">{{ $entry->car_number }}</a>

									@if( $entry->color )
									<span class="pull-right glyphicon glyphicon-stop" style="color: {{ $entry->color }}"></span>
									@endif
								</td>
								<td>
									<a href="{{ route( 'admin.entries.edit', [ 'entry' => $entry->id ] ) }}">{{ $entry->team->name }}</a>
								</td>
								<td>
									<a href="{{ route( 'admin.entries.edit', [ 'entry' => $entry->id ] ) }}">{{ $entry->driver->fullName }}</a>
								</td>
								<td>
									<a href="{{ route( 'admin.entries.edit', [ 'entry' => $entry->id ] ) }}">{{ $entry->abbreviation }}</a>
								</td>
								<td>
									<span class="glyphicon glyphicon-{{ $entry->active ? 'ok text-success' : 'remove text-danger' }}"></span>
								</td>
								<td class="text-center">
									<a href="{{ route( 'admin.entries.edit', [ 'entry' => $entry->id ] ) }}" title="@lang('Edit this entry')" class="glyphicon glyphicon-pencil"></a>
								</td>
								<td class="text-center">
									@if( $entry->results->isEmpty() and $entry->picks->isEmpty() )
										<a href="{{ route( 'admin.entries.destroy', [ 'entry' => $entry->id ] ) }}" title="@lang('Delete this entry')" class="glyphicon glyphicon-trash"></a>
									@else
										&nbsp;
									@endif
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="6" class="text-center">
									<p>
										@lang('No entries found.')
									</p>
									<p>
										<a class="btn btn-primary" href="{{ route('admin.entries.populate', [ 'season' => $currentSeason ]) }}">@lang('Populate with entries from previous season (:year)', [ 'year' => $currentSeason->previous->name ])</a>
									</p>
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>

				<div class="text-center">
					{{ $entries->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection
