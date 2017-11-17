@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route('admin.teams.store') }}">
                        {{ csrf_field() }}

			@component('admin.form.input')
				@slot('field', 'name')
				
				@slot('label', 'Name')
				
				@slot('attributes')
					required autofocus
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
				@slot('cancel', route('admin.teams.index'))
				
				Add team
			@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
