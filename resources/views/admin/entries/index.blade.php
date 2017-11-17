@extends('admin.index')

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
								Car number
							</th>
							<th>
								Team
							</th>
							<th>
								Driver
							</th>
							<th>
								Active
							</th>
							<th colspan="2" class="text-center">
								<a href="{{ route( 'admin.entries.create', [ 'season' => $currentSeason->id ] ) }}" title="Add a entry" class="glyphicon glyphicon-plus"></a>
							</th>
						</tr>
					</thead>
					<tbody>
						@forelse( $entries as $entry )
							<tr>
								<td>
									<a href="{{ route( 'admin.entries.edit', [ 'seasons' => $entry->id ] ) }}">{{ $entry->car_number }}</a>
									
									@if( $entry->color )
									<span class="pull-right glyphicon glyphicon-stop" style="color: {{ $entry->color }}"></span>
									@endif
								</td>
								<td>
									<a href="{{ route( 'admin.entries.edit', [ 'seasons' => $entry->id ] ) }}">{{ $entry->team->name }}</a>
								</td>
								<td>
									<a href="{{ route( 'admin.entries.edit', [ 'seasons' => $entry->id ] ) }}">{{ $entry->driver->fullName }}</a>
								</td>
								<td>
									<span class="glyphicon glyphicon-{{ $entry->active ? 'ok text-success' : 'remove text-danger' }}"></span>
								</td>
								<td class="text-center">
									<a href="{{ route( 'admin.entries.edit', [ 'seasons' => $entry->id ] ) }}" title="Edit this entry" class="glyphicon glyphicon-pencil"></a>
								</td>
								<td class="text-center">
									@if( $entry->results->isEmpty() and $entry->picks->isEmpty() )
										<a href="{{ route( 'admin.entries.destroy', [ 'entries' => $entry->id ] ) }}" title="Delete this entry" class="glyphicon glyphicon-trash"></a>
									@else
										&nbsp;
									@endif
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="5" class="text-center">No entries found.</td>
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
