@extends('admin.index')

@section('title', __('Edit leagues of user') . ' - ' . __('Admin') . ' -')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif

				@if (session('error'))
					<div class="alert alert-danger">
						{{ session('error') }}
					</div>
				@endif

				<div class="text-center">
					@lang('Add or remove leagues for user :name:', [ 'name' => '<strong>' . $user->name . '</strong>' ])
				</div>
				
				<div class="text-center">
					{{ $leagues->links() }}
				</div>
				
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>
								@lang('Name')
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
										<a href="{{ route( 'admin.userleagues.detach', [ 'user' => $user->id, 'league' => $league->id ] ) }}"><span class="glyphicon glyphicon-ok text-success"></span></a>
									@else
										<a href="{{ route( 'admin.userleagues.attach', [ 'user' => $user->id, 'league' => $league->id ] ) }}"><span class="glyphicon glyphicon-remove text-danger"></span></a>
									@endif
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="2" class="text-center">@lang('No leagues found.')</td>
							</tr>
						@endforelse
					</tbody>
				</table>
				
				<div class="text-center">
					{{ $leagues->links() }}
				</div>
				
				<div class="text-center">
					<a class="btn btn-primary" href="{{ route('admin.userleagues.index') }}">Go to index</a>
				</div>
			</div>
		</div>
	</div>
@endsection
