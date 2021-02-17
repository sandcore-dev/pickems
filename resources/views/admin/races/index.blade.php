@extends('admin.index')

@section('title', __('Races') . ' - ' . __('Admin') . ' -')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				@include('admin.races.series')
				@include('admin.races.seasons')

				@if(session('error'))
					<div class="alert alert-warning">
						{{ session('error') }}
					</div>
				@endif

				@if(session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif

				<div class="text-center">
					{{ $races->links() }}
				</div>

				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>
								@lang('Race day')
							</th>
							<th>
								@lang('Name')
							</th>
							<th>
								@lang('Start of weekend')
							</th>
							<th colspan="2" class="text-center">
								<a href="{{ route( 'admin.races.create', [ 'race' => $currentSeason->id ] ) }}" title="@lang('Add a race')" class="glyphicon glyphicon-plus"></a>
							</th>
						</tr>
					</thead>
					<tbody>
						@forelse( $races as $race )
							<tr>
								<td>
									<a href="{{ route( 'admin.races.edit', [ 'race' => $race->id ] ) }}">{{ $race->race_day->formatLocalized('%d %B') }}</a>
								</td>
								<td>
									<a href="{{ route( 'admin.races.edit', [ 'race' => $race->id ] ) }}">{{ $race->name }}</a>
								</td>
								<td>
									<a href="{{ route( 'admin.races.edit', [ 'race' => $race->id ] ) }}">{{ $race->weekend_start->formatLocalized('%d %B %H:%M') }}</a>
								</td>
								<td class="text-center">
									<a href="{{ route( 'admin.races.edit', [ 'race' => $race->id ] ) }}" title="@lang('Edit this race')" class="glyphicon glyphicon-pencil"></a>
								</td>
								<td class="text-center">
									@if( !$race->results->count() )
										<a href="{{ route( 'admin.races.destroy', [ 'race' => $race->id ] ) }}" title="@lang('Delete this race')" class="glyphicon glyphicon-trash"></a>
									@else
										&nbsp;
									@endif
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="5" class="text-center">
									<p>
										@lang('No races found.')
									</p>
									<p>
										<a class="btn btn-primary" href="{{ route('admin.races.populate', [ 'season' => $currentSeason ]) }}">@lang('Populate with races from previous season (:year)', [ 'year' => $currentSeason->previous->name ])</a>
									</p>
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>

				<div class="text-center">
					{{ $races->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection
