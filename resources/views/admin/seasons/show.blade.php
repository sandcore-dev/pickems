@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route( 'admin.seasons.destroy', [ 'seasons' => $season->id ] ) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <div class="form-group text-center">
                        	Do you want to delete the season <strong>{{ $season->name }}</strong> from the series <strong>{{ $season->series->name }}</strong>?
                        </div>

			@component('admin.form.submit')
				@slot('cancel', route( 'admin.seasons.index', [ 'series' => $season->series->id ] ))
				
				@slot('context', 'danger')
				
				Delete season
			@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
