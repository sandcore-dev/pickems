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
					{{ $teams->links() }}
				</div>
				
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>
								Name
							</th>
							<th>
								Country
							</th>
							<th>
								Active
							</th>
							<th colspan="2" class="text-center">
								<a href="{{ route('admin.teams.create') }}" title="Add a team" class="glyphicon glyphicon-plus"></a>
							</th>
						</tr>
					</thead>
					<tbody>
						@forelse( $teams as $team )
							<tr>
								<td>
									<a href="{{ route( 'admin.teams.edit', [ 'teams' => $team->id ] ) }}">{{ $team->name }}</a>
								</td>
								<td>
									<span class="flag-icon flag-icon-{{ strtolower( $team->country->code ) }}" title="{{ $team->country->name }}"></span>
								</td>
								<td>
									<span class="glyphicon glyphicon-{{ $team->active ? 'ok text-success' : 'remove text-danger' }}"></span>
								</td>
								<td class="text-center">
									<a href="{{ route( 'admin.teams.edit', [ 'teams' => $team->id ] ) }}" title="Edit this team" class="glyphicon glyphicon-pencil"></a>
								</td>
								<td class="text-center">
									@if( !$team->entries->count() )
										<a href="{{ route( 'admin.teams.destroy', [ 'teams' => $team->id ] ) }}" title="Delete this team" class="glyphicon glyphicon-trash"></a>
									@else
										&nbsp;
									@endif
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="3" class="text-center">No teams found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
				
				<div class="text-center">
					{{ $teams->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection
