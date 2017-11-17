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
					{{ $countries->links() }}
				</div>
				
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>
								Name
							</th>
							<th colspan="2" class="text-center">
								<a href="{{ route('admin.countries.create') }}" title="Add a country" class="glyphicon glyphicon-plus"></a>
							</th>
						</tr>
					</thead>
					<tbody>
						@forelse( $countries as $country )
							<tr>
								<td>
									<a href="{{ route( 'admin.countries.edit', [ 'countries' => $country->id ] ) }}">{{ $country->name }}</a>
								</td>
								<td class="text-center">
									<a href="{{ route( 'admin.countries.edit', [ 'countries' => $country->id ] ) }}" title="Edit this country" class="glyphicon glyphicon-pencil"></a>
								</td>
								<td class="text-center">
									@if( !$country->circuit )
										<a href="{{ route( 'admin.countries.destroy', [ 'countries' => $country->id ] ) }}" title="Delete this country" class="glyphicon glyphicon-trash"></a>
									@else
										&nbsp;
									@endif
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="3" class="text-center">No countries found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
				
				<div class="text-center">
					{{ $countries->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection
