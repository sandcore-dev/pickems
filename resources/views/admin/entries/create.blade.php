@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route('admin.entries.store') }}">
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
				@slot('type', 'number')
				
				@slot('field', 'car_number')
				
				@slot('label', 'Car number')
				
				@slot('attributes')
					required autofocus
				@endslot
			@endcomponent
			
			@component('admin.form.select')
				@slot('field', 'team_id')
				
				@slot('label', 'Team')
				
				@slot('options', $teams)
			@endcomponent

			@component('admin.form.select')
				@slot('field', 'driver_id')
				
				@slot('label', 'Driver')
				
				@slot('options', $drivers)
				
				@slot('option_label', 'lastFirst')
			@endcomponent

			@component('admin.form.input')
				@slot('type', 'color')
				
				@slot('field', 'color')
				
				@slot('label', 'Color')
				
				@slot('attributes')
					required
				@endslot
			@endcomponent

			@component('admin.form.input')
				@slot('field', 'abbreviation')
				
				@slot('label', 'Abbreviation')
				
				@slot('attributes')
					required maxlength="3"
				@endslot
			@endcomponent

			@component('admin.form.checkbox')
				@slot('field', 'active')
				
				@slot('value', 1)
				
				@slot('label', 'Active')
			@endcomponent
			
			@component('admin.form.submit')
				@slot('cancel', route( 'admin.entries.index', [ 'season' => $season->id ] ))
				
				Add entry
			@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
