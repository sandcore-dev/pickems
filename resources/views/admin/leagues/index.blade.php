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
					{{ $leagues->links() }}
				</div>
				
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>
								Name
							</th>
							<th colspan="2" class="text-center">
								<a href="{{ route( 'admin.leagues.create' ) }}" title="Add a league" class="glyphicon glyphicon-plus"></a>
							</th>
						</tr>
					</thead>
					<tbody>
						@forelse( $leagues as $league )
							<tr>
								<td>
									<a href="{{ route( 'admin.leagues.edit', [ 'leagues' => $league->id ] ) }}">{{ $league->name }}</a>
								</td>
								<td class="text-center">
									<a href="{{ route( 'admin.leagues.edit', [ 'leagues' => $league->id ] ) }}" title="Edit this league" class="glyphicon glyphicon-pencil"></a>
								</td>
								<td class="text-center">
									@if( $league->users->isEmpty() )
									<a href="{{ route( 'admin.leagues.destroy', [ 'leagues' => $league->id ] ) }}" title="Delete this league" class="glyphicon glyphicon-trash"></a>
									@endif
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="5" class="text-center">No leagues found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
				
				<div class="text-center">
					{{ $leagues->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection
