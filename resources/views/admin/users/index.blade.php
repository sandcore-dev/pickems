@extends('admin.index')

@section('title', __('Users') . ' - ' . __('Admin') . ' -')

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
					{{ $users->links() }}
				</div>

				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>
								@lang('Name') (@lang('admin'))
							</th>
							<th>
								@lang('E-mail') (@lang('reminder'))
							</th>
							<th>
								@lang('Username')
							</th>
							<th>
								@lang('Active')
							</th>
							<th colspan="2" class="text-center">
								<a href="{{ route( 'admin.users.create' ) }}" title="@lang('Add a user')" class="glyphicon glyphicon-plus"></a>
							</th>
						</tr>
					</thead>
					<tbody>
						@forelse( $users as $user )
							<tr>
								<td>
									<a href="{{ route( 'admin.users.edit', [ 'user' => $user->id ] ) }}">{{ $user->name }}</a>
									@if( $user->is_admin )
									<span class="glyphicon glyphicon-globe"></span>
									@endif
								</td>
								<td>
									<a href="{{ route( 'admin.users.edit', [ 'user' => $user->id ] ) }}">{{ $user->email }}</a>

									@if( $user->email )
										<span class="glyphicon glyphicon-{{ $user->reminder ? 'ok text-success' : 'remove text-danger' }}"></span>
									@endif
								</td>
								<td>
									<a href="{{ route( 'admin.users.edit', [ 'user' => $user->id ] ) }}">{{ $user->username }}</a>
								</td>
								<td>
									<span class="glyphicon glyphicon-{{ $user->active ? 'ok text-success' : 'remove text-danger' }}"></span>
								</td>
								<td class="text-center">
									<a href="{{ route( 'admin.users.edit', [ 'user' => $user->id ] ) }}" title="@lang('Edit this user')" class="glyphicon glyphicon-pencil"></a>
								</td>
								<td class="text-center">
									@unless( $user->is_admin )
									<a href="{{ route( 'admin.users.destroy', [ 'user' => $user->id ] ) }}" title="@lang('Delete this user')" class="glyphicon glyphicon-trash"></a>
									@endunless
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="5" class="text-center">@lang('No users found.')</td>
							</tr>
						@endforelse
					</tbody>
				</table>

				<div class="text-center">
					{{ $users->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection
