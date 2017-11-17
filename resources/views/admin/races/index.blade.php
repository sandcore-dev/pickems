@extends('admin.index')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				@include('admin.races.series')
				@include('admin.races.seasons')

				@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif

				<div class="text-center">
					{{ $races->links() }}
				</div>
				
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>
								Race day
							</th>
							<th>
								Name
							</th>
							<th>
								Start of weekend
							</th>
							<th colspan="2" class="text-center">
								<a href="{{ route( 'admin.races.create', [ 'season' => $currentSeason->id ] ) }}" title="Add a race" class="glyphicon glyphicon-plus"></a>
							</th>
						</tr>
					</thead>
					<tbody>
						@forelse( $races as $race )
							<tr>
								<td>
									<a href="{{ route( 'admin.races.edit', [ 'seasons' => $race->id ] ) }}">{{ $race->race_day->format('F d') }}</a>
								</td>
								<td>
									<a href="{{ route( 'admin.races.edit', [ 'seasons' => $race->id ] ) }}">{{ $race->name }}</a>
								</td>
								<td>
									<a href="{{ route( 'admin.races.edit', [ 'seasons' => $race->id ] ) }}">{{ $race->weekend_start->format('M d, H:i') }}</a>
								</td>
								<td class="text-center">
									<a href="{{ route( 'admin.races.edit', [ 'seasons' => $race->id ] ) }}" title="Edit this season" class="glyphicon glyphicon-pencil"></a>
								</td>
								<td class="text-center">
									@if( !$race->results()->count() )
										<a href="{{ route( 'admin.races.destroy', [ 'seasons' => $race->id ] ) }}" title="Delete this season" class="glyphicon glyphicon-trash"></a>
									@else
										&nbsp;
									@endif
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="5" class="text-center">No races found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
				
				<div class="text-center">
					{{ $races->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection
