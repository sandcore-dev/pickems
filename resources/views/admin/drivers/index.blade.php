@extends('admin.index')

@section('title', __('Drivers') . ' - ' . __('Admin') . ' -')

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
					{{ $drivers->links() }}
				</div>
				
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>
								@lang('First name')
							</th>
							<th>
								@lang('Last name')
							</th>
							<th>
								@lang('Country')
							</th>
							<th>
								@lang('Active')
							</th>
							<th colspan="2" class="text-center">
								<a href="{{ route('admin.drivers.create') }}" title="@lang('Add a driver')" class="glyphicon glyphicon-plus"></a>
							</th>
						</tr>
					</thead>
					<tbody>
						@forelse( $drivers as $driver )
							<tr>
								<td>
									<a href="{{ route( 'admin.drivers.edit', [ 'drivers' => $driver->id ] ) }}">{{ $driver->first_name }}</a>
								</td>
								<td>
									<a href="{{ route( 'admin.drivers.edit', [ 'drivers' => $driver->id ] ) }}">{{ $driver->last_name }}</a>
								</td>
								<td>
									<span class="{{ $driver->country->flagClass }} title="{{ $driver->country->localName }}"></span>
								</td>
								<td>
									<span class="glyphicon glyphicon-{{ $driver->active ? 'ok text-success' : 'remove text-danger' }}"></span>
								</td>
								<td class="text-center">
									<a href="{{ route( 'admin.drivers.edit', [ 'drivers' => $driver->id ] ) }}" title="@lang('Edit this driver')" class="glyphicon glyphicon-pencil"></a>
								</td>
								<td class="text-center">
									@if( !$driver->entries->count() )
										<a href="{{ route( 'admin.drivers.destroy', [ 'drivers' => $driver->id ] ) }}" title="@lang('Delete this driver')" class="glyphicon glyphicon-trash"></a>
									@else
										&nbsp;
									@endif
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="3" class="text-center">@lang('No drivers found.')</td>
							</tr>
						@endforelse
					</tbody>
				</table>
				
				<div class="text-center">
					{{ $drivers->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection
