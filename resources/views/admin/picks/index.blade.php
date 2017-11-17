@extends('admin.index')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				@include('admin.picks.series')
				@include('admin.picks.seasons')
				@include('admin.picks.races')
				
				@include('admin.picks.leagues')
				@include('admin.picks.users')

				@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif
			</div>
		</div>
	</div>
	
	@include('admin.picks.grid')
@endsection
