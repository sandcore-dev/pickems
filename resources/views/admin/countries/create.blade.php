@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route('countries.store') }}">
                        {{ csrf_field() }}

			@component('admin.form.input')
				@slot('field', 'code')
				
				@slot('label', 'Code')
				
				@slot('attributes')
					required autofocus
				@endslot
			@endcomponent
			
			@component('admin.form.input')
				@slot('field', 'name')
				
				@slot('label', 'Name')
				
				@slot('attributes')
					required
				@endslot
			@endcomponent

			@component('admin.form.submit')
				@slot('cancel', route('circuits.index'))
				
				Add country
			@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
