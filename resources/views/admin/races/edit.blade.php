@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route( 'admin.races.update', [ 'races' => $race->id ] ) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        
			@component('admin.form.input')
				@slot('field', 'series')
				
				@slot('value', $race->season->series->name)
				
				@slot('label', 'Series')
				
				@slot('attributes')
					disabled
				@endslot
			@endcomponent
			
			@component('admin.form.input')
				@slot('field', 'season')
				
				@slot('value', $race->season->name)
				
				@slot('label', 'Season')
				
				@slot('attributes')
					disabled
				@endslot
			@endcomponent
			
			@component('admin.form.input')
				@slot('field', 'name')
				
				@slot('value', $race->name)
				
				@slot('label', 'Name')
				
				@slot('attributes')
					required autofocus
				@endslot
			@endcomponent
			
			@component('admin.form.select')
				@slot('field', 'circuit_id')
				
				@slot('value', $race->circuit_id)
				
				@slot('label', 'Circuit')
				
				@slot('options', $circuits)
				
				@slot('attributes')
					required
				@endslot
			@endcomponent
			
			@component('admin.form.date')
				@slot('field', 'race_day')
				
				@slot('label', 'Race day')
				
				@slot('value', $race->race_day)
				
				@slot('year_attributes')
					min="{{ $race->season->start_year }}" max="{{ $race->season->end_year }}"
				@endslot
			@endcomponent
			
			@component('admin.form.datetime')
				@slot('field', 'weekend_start')
				
				@slot('label', 'Weekend start')
				
				@slot('value', $race->weekend_start))
				
				@slot('year_attributes')
					min="{{ $race->season->start_year }}" max="{{ $race->season->end_year }}"
				@endslot
			@endcomponent
			
			@component('admin.form.submit')
				@slot('cancel', route( 'admin.races.index', [ 'season' => $race->season->id ] ))
				
				Edit race
			@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
