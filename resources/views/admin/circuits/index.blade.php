@extends('admin.index')

@section('title', __('Circuits') . ' - ' . __('Admin') . ' -')

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
					{{ $circuits->links() }}
				</div>

				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>
								@lang('Name')
							</th>
							<th>
								@lang('City')
							</th>
							<th colspan="2" class="text-center">
								<a href="{{ route('admin.circuits.create') }}" title="@lang('Add a circuit')" class="glyphicon glyphicon-plus"></a>
							</th>
						</tr>
					</thead>
					<tbody>
						@forelse( $circuits as $circuit )
							<tr>
								<td>
									<a href="{{ route( 'admin.circuits.edit', [ 'circuit' => $circuit->id ] ) }}">{{ $circuit->name }}</a>
								</td>
								<td>
									<a href="{{ route( 'admin.circuits.edit', [ 'circuit' => $circuit->id ] ) }}">{{ $circuit->localLocation }}</a>
								</td>
								<td class="text-center">
									<a href="{{ route( 'admin.circuits.edit', [ 'circuit' => $circuit->id ] ) }}" title="@lang('Edit this circuit')" class="glyphicon glyphicon-pencil"></a>
								</td>
								<td class="text-center">
									@if( !$circuit->races->count() )
										<a href="{{ route( 'admin.circuits.destroy', [ 'circuit' => $circuit->id ] ) }}" title="@lang('Delete this circuit')" class="glyphicon glyphicon-trash"></a>
									@else
										&nbsp;
									@endif
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="3" class="text-center">@lang('No circuits found.')</td>
							</tr>
						@endforelse
					</tbody>
				</table>

				<div class="text-center">
					{{ $circuits->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection
