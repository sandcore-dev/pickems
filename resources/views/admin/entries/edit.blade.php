@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route( 'entries.update', [ 'entries' => $entry->id ] ) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        
			@component('admin.form.input')
				@slot('field', 'series')
				
				@slot('value', $entry->season->series->name)
				
				@slot('label', 'Series')
				
				@slot('attributes')
					disabled
				@endslot
			@endcomponent
			
			@component('admin.form.input')
				@slot('field', 'season')
				
				@slot('value', $entry->season->name)
				
				@slot('label', 'Season')
				
				@slot('attributes')
					disabled
				@endslot
			@endcomponent
			
			@component('admin.form.input')
				@slot('type', 'number')
				
				@slot('field', 'car_number')
				
				@slot('value', $entry->car_number)
				
				@slot('label', 'Car number')
				
				@slot('attributes')
					required autofocus
				@endslot
			@endcomponent
			
			@component('admin.form.select')
				@slot('field', 'team_id')
				
				@slot('value', $entry->team_id)

				@slot('label', 'Team')
				
				@slot('options', $teams)
			@endcomponent

			@component('admin.form.select')
				@slot('field', 'driver_id')
				
				@slot('value', $entry->driver_id)

				@slot('label', 'Driver')
				
				@slot('options', $drivers)
				
				@slot('option_label', 'lastFirst')
			@endcomponent

			@component('admin.form.checkbox')
				@slot('field', 'active')
				
				@slot('value', $entry->active)
				
				@slot('label', 'Active')
			@endcomponent
			
			@component('admin.form.submit')
				@slot('cancel', route( 'entries.index', [ 'season' => $entry->season->id ] ))
				
				Edit entry
			@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
