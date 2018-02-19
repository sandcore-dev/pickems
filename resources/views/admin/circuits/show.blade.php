@extends('admin.index')

@section('title', __('Delete circuit') . ' - ' . __('Admin') . ' -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route( 'admin.circuits.destroy', [ 'circuits' => $circuit->id ] ) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <div class="form-group text-center">
                        	@lang('Do you want to delete the circuit :name?', [ 'name' => '<strong>' . $circuit->name . '</strong>' ])
                        </div>

						@component('admin.form.submit')
							@slot('cancel', route('admin.circuits.index'))
							
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
