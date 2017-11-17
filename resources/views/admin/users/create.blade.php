@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route('admin.users.store') }}">
                        {{ csrf_field() }}
                        
			@component('admin.form.input')
				@slot('field', 'name')
				
				@slot('label', 'Name')
				
				@slot('attributes')
					required autofocus
				@endslot
			@endcomponent
			
			@component('admin.form.input')
				@slot('type', 'email')
				
				@slot('field', 'email')
				
				@slot('label', 'E-mail')
				
				@slot('attributes')
					required
				@endslot
			@endcomponent

			@component('admin.form.checkbox')
				@slot('field', 'reminder')
				
				@slot('label', 'Remind user to pick')
			@endcomponent
			
			@component('admin.form.input')
				@slot('field', 'username')
				
				@slot('label', 'Username')
				
				@slot('attributes')
					required
				@endslot
			@endcomponent

			@component('admin.form.input')
				@slot('type', 'password')
				
				@slot('field', 'password')
				
				@slot('label', 'Password')
				
				@slot('attributes')
					required
				@endslot
			@endcomponent

			@component('admin.form.checkbox')
				@slot('field', 'active')
				
				@slot('value', 1)
				
				@slot('label', 'Active')
			@endcomponent
			
			@component('admin.form.checkbox')
				@slot('field', 'is_admin')
				
				@slot('label', 'Administrator access')
			@endcomponent
			
			@component('admin.form.submit')
				@slot('cancel', route( 'admin.users.index' ) )
				
				Add user
			@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
