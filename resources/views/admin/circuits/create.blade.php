@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route('admin.circuits.store') }}">
                        {{ csrf_field() }}

			@component('admin.form.input')
				@slot('field', 'name')
				
				@slot('label', 'Name')
				
				@slot('attributes')
					required autofocus
				@endslot
			@endcomponent
			
			@component('admin.form.input')
				@slot('type',  'number')
				
				@slot('field', 'length')
				
				@slot('label', 'Length (meter)')
				
				@slot('attributes')
					required min="1"
				@endslot
			@endcomponent
			
			@component('admin.form.input')
				@slot('field', 'city')
				
				@slot('label', 'City')
				
				@slot('attributes')
					required
				@endslot
			@endcomponent
			
			@component('admin.form.input')
				@slot('field', 'area')
				
				@slot('label', 'Area')
			@endcomponent

			@component('admin.form.select')
				@slot('field', 'country_id')
				
				@slot('label', 'Country')
				
				@slot('options', $countries)
			@endcomponent

			@component('admin.form.submit')
				@slot('cancel', route('admin.circuits.index'))
				
				Add circuit
			@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
