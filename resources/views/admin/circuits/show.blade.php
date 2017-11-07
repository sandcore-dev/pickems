@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route( 'circuits.destroy', [ 'circuits' => $circuit->id ] ) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <div class="form-group text-center">
                        	Do you want to delete the circuit <strong>{{ $circuit->name }}</strong>?
                        </div>

			@component('admin.form.submit')
				@slot('cancel', route('circuits.index'))
				
				@slot('context', 'danger')
				
				Delete circuit
			@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
