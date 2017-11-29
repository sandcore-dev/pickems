@extends('admin.index')

@section('title', 'Add season - Admin -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route('admin.seasons.store') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="series_id" value="{{ $series->id }}">

			@component('admin.form.input')
				@slot('field', 'series')
				
				@slot('value', $series->name)
				
				@slot('label', 'Series')
				
				@slot('attributes')
					disabled
				@endslot
			@endcomponent
			
			@component('admin.form.input')
				@slot('type', 'number')
				
				@slot('field', 'start_year')
				
				@slot('label', 'Start year')
				
				@slot('attributes')
					required autofocus min="1970"
				@endslot
			@endcomponent
			
			@component('admin.form.input')
				@slot('type', 'number')
				
				@slot('field', 'end_year')
				
				@slot('label', 'End year')
				
				@slot('attributes')
					required min="1970"
				@endslot
			@endcomponent

			@component('admin.form.input')
				@slot('type', 'number')
				
				@slot('field', 'picks_max')
				
				@slot('value', config("picks.max"))
				
				@slot('label', 'Picks maximum')
				
				@slot('attributes')
					required min="{{ config('picks.min') }}" max="{{ config('picks.max') }}"
				@endslot
			@endcomponent

			@component('admin.form.submit')
				@slot('cancel', route( 'admin.seasons.index', [ 'series' => $series->id ] ))
				
				Add season
			@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
