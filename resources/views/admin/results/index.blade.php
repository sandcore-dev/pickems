@extends('admin.index')

@section('title', __('Results') . ' - ' . __('Admin') . ' -')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				@include('admin.results.series')
				@include('admin.results.seasons')
				@include('admin.results.races')
				@include('admin.results.recalculate')

				@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif
			</div>
		</div>
	</div>
	
	@include('admin.results.grid')
@endsection
