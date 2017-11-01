@extends('admin.index')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif

				<div class="text-center">
					{{ $series->links() }}
				</div>
				
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>
								Name
							</th>
							<th colspan="2" class="text-center">
								<a href="{{ route('series.create') }}" title="Add a series" class="glyphicon glyphicon-plus"></a>
							</th>
						</tr>
					</thead>
					<tbody>
						@forelse( $series as $serie )
							<tr>
								<td>
									<a href="{{ route( 'series.edit', [ 'series' => $serie->id ] ) }}">{{ $serie->name }}</a>
								</td>
								<td class="text-center">
									<a href="{{ route( 'series.edit', [ 'series' => $serie->id ] ) }}" title="Edit this series" class="glyphicon glyphicon-pencil"></a>
								</td>
								<td class="text-center">
									@if( !$serie->seasons->count() )
										<a href="{{ route( 'series.destroy', [ 'series' => $serie->id ] ) }}" title="Delete this series" class="glyphicon glyphicon-trash"></a>
									@else
										&nbsp;
									@endif
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="3" class="text-center">No series found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
				
				<div class="text-center">
					{{ $series->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection
