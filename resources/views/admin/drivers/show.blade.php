@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route( 'drivers.destroy', [ 'drivers' => $driver->id ] ) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <div class="form-group text-center">
                        	Do you want to delete the driver <strong>{{ $driver->fullName }}</strong>?
                        </div>

			@component('admin.form.submit')
				@slot('cancel', route('drivers.index'))
				
				@slot('context', 'danger')
				
				Delete driver
			@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
