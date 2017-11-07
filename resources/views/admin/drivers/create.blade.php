@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route('drivers.store') }}">
                        {{ csrf_field() }}

			@component('admin.form.input')
				@slot('field', 'first_name')
				
				@slot('label', 'First name')
				
				@slot('attributes')
					required autofocus
				@endslot
			@endcomponent

			@component('admin.form.input')
				@slot('field', 'last_name')
				
				@slot('label', 'Last name')
				
				@slot('attributes')
					required
				@endslot
			@endcomponent

			@component('admin.form.select')
				@slot('field', 'country_id')
				
				@slot('label', 'Country')
				
				@slot('options', $countries)
			@endcomponent

			@component('admin.form.checkbox')
				@slot('field', 'active')
				
				@slot('label', 'Active')
			@endcomponent

			@component('admin.form.submit')
				@slot('cancel', route('drivers.index'))
				
				Add driver
			@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
