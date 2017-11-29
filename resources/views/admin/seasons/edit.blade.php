@extends('admin.index')

@section('title', 'Edit season - Admin -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route( 'admin.seasons.update', [ 'seasons' => $season->id ] ) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

			@component('admin.form.input')
				@slot('field', 'series')
				
				@slot('value', $season->series->name)
				
				@slot('label', 'Series')
				
				@slot('attributes')
					disabled
				@endslot
			@endcomponent
			
			@component('admin.form.input')
				@slot('type', 'number')
				
				@slot('field', 'start_year')
				
				@slot('value', $season->start_year)
				
				@slot('label', 'Start year')
				
				@slot('attributes')
					required autofocus min="1970"
				@endslot
			@endcomponent
			
			@component('admin.form.input')
				@slot('type', 'number')
				
				@slot('field', 'end_year')
				
				@slot('value', $season->end_year)

				@slot('label', 'End year')
				
				@slot('attributes')
					required min="1970"
				@endslot
			@endcomponent

			@component('admin.form.input')
				@slot('type', 'number')
				
				@slot('field', 'picks_max')
				
				@slot('value', $season->picks_max)
				
				@slot('label', 'Picks maximum')
				
				@slot('attributes')
					required min="{{ config('picks.min') }}" max="{{ config('picks.max') }}"
				@endslot
			@endcomponent
			
			@component('admin.form.submit')
				@slot('cancel', route( 'admin.seasons.index', [ 'series' => $season->series->id ] ))
				
				Edit season
			@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
