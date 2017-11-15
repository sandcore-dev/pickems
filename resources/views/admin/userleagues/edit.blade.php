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
					Add or remove leagues for user <strong>{{ $user->name }}</strong>:
				</div>
				
				<div class="text-center">
					{{ $leagues->links() }}
				</div>
				
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>
								Name
							</th>
							<th>
								&nbsp;
							</th>
						</tr>
					</thead>
					<tbody>
						@forelse( $leagues as $league )
							<tr>
								<td>
									{{ $league->name }}
								</td>
								<td class="text-center">
									@if( $user->leagues->contains($league) )
										<a href="{{ route( 'userleagues.detach', [ 'user' => $user->id, 'league' => $league->id ] ) }}"><span class="glyphicon glyphicon-ok text-success"></span></a>
									@else
										<a href="{{ route( 'userleagues.attach', [ 'user' => $user->id, 'league' => $league->id ] ) }}"><span class="glyphicon glyphicon-remove text-danger"></span></a>
									@endif
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="2" class="text-center">No leagues found.</td>
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
