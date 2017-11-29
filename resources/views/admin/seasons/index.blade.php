@extends('admin.index')

@section('title', 'Seasons - Admin -')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				@include('admin.seasons.series')

				@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif

				<div class="text-center">
					{{ $seasons->links() }}
				</div>
				
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>
								Name
							</th>
							<th>
								Picks
							</th>
							<th colspan="2" class="text-center">
								<a href="{{ route( 'admin.seasons.create', [ 'series' => $currentSeries->id ] ) }}" title="Add a season" class="glyphicon glyphicon-plus"></a>
							</th>
						</tr>
					</thead>
					<tbody>
						@forelse( $seasons as $season )
							<tr>
								<td>
									<a href="{{ route( 'admin.seasons.edit', [ 'seasons' => $season->id ] ) }}">{{ $season->name }}</a>
								</td>
								<td>
									<a href="{{ route( 'admin.seasons.edit', [ 'seasons' => $season->id ] ) }}">{{ $season->picks_max }}</a>
								</td>
								<td class="text-center">
									<a href="{{ route( 'admin.seasons.edit', [ 'seasons' => $season->id ] ) }}" title="Edit this season" class="glyphicon glyphicon-pencil"></a>
								</td>
								<td class="text-center">
									@if( !$season->races->count() )
										<a href="{{ route( 'admin.seasons.destroy', [ 'seasons' => $season->id ] ) }}" title="Delete this season" class="glyphicon glyphicon-trash"></a>
									@else
										&nbsp;
									@endif
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="4" class="text-center">No seasons found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
				
				<div class="text-center">
					{{ $seasons->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection
