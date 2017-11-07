@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route('races.store') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="season_id" value="{{ $season->id }}">
                        
			@component('admin.form.input')
				@slot('field', 'series')
				
				@slot('value', $season->series->name)
				
				@slot('label', 'Series')
				
				@slot('attributes')
					disabled
				@endslot
			@endcomponent
			
			@component('admin.form.input')
				@slot('field', 'season')
				
				@slot('value', $season->name)
				
				@slot('label', 'Season')
				
				@slot('attributes')
					disabled
				@endslot
			@endcomponent
			
			@component('admin.form.input')
				@slot('field', 'name')
				
				@slot('label', 'Name')
				
				@slot('attributes')
					required autofocus
				@endslot
			@endcomponent
			
			@component('admin.form.select')
				@slot('field', 'circuit_id')
				
				@slot('label', 'Circuit')
				
				@slot('options', $circuits)
				
				@slot('attributes')
					required
				@endslot
			@endcomponent
			
			@component('admin.form.date')
				@slot('field', 'race_day')
				
				@slot('label', 'Race day')
				
				@slot('value', \Carbon\Carbon::createFromDate($season->start_year))
				
				@slot('year_attributes')
					min="{{ $season->start_year }}" max="{{ $season->end_year }}"
				@endslot
			@endcomponent
			
			@component('admin.form.datetime')
				@slot('field', 'weekend_start')
				
				@slot('label', 'Weekend start')
				
				@slot('value', \Carbon\Carbon::createFromDate($season->start_year))
				
				@slot('year_attributes')
					min="{{ $season->start_year }}" max="{{ $season->end_year }}"
				@endslot
			@endcomponent
			
			@component('admin.form.submit')
				@slot('cancel', route( 'races.index', [ 'season' => $season->id ] ))
				
				Add race
			@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
