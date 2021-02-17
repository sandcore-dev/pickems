@extends('admin.index')

@section('title', __("User's leagues") . ' - ' . __('Admin') . ' -')

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
								@lang('Name')
							</th>
							<th>
								@lang('League(s)')
							</th>
							<th class="text-center">
								&nbsp;
							</th>
						</tr>
					</thead>
					<tbody>
						@forelse( $users as $user )
							<tr>
								<td>
									<a href="{{ route( 'admin.userleagues.edit', [ 'user' => $user->id ] ) }}">{{ $user->name }}</a>
								</td>
								<td>
									@forelse( $user->leagues->take(3) as $league )
										{{ $league->name }}<br>
									@empty
										&nbsp;
									@endforelse

									@if( $user->leagues->count() > 3 )
										and {{ $user->leagues->count() - 3 }} other(s)
									@endif
								</td>
								<td class="text-center">
									<a href="{{ route( 'admin.userleagues.edit', [ 'user' => $user->id ] ) }}" title="@lang('Edit leagues of this user')" class="glyphicon glyphicon-pencil"></a>
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
