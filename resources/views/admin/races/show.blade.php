@extends('admin.index')

@section('title', __('Delete race') . ' - ' . __('Admin') . ' -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route( 'admin.races.destroy', [ 'races' => $race->id ] ) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <div class="form-group text-center">
                        	@lang('Do you want to delete the race :race from the season :season of the series :series?', [ 'race' => '<strong>' . $race->name . '</strong>', 'season' => '<strong>' . $race->season->name . '</strong>', 'series' => '<strong>' .  $race->season->series->name . '</strong>' ])
                        </div>

						@component('admin.form.submit')
							@slot('cancel', route( 'admin.races.index', [ 'races' => $race->season->id ] ))
							
							@slot('context', 'danger')
							
							Delete race
						@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
