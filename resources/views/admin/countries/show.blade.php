@extends('admin.index')

@section('title', __('Delete country') . ' - ' . __('Admin') . ' -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route( 'admin.countries.destroy', [ 'countries' => $country->id ] ) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <div class="form-group text-center">
                        	@lang('Do you want to delete the country :name?', [ 'name' => '<strong>' . $country->name . '</strong>' ])
                        </div>

						@component('admin.form.submit')
							@slot('cancel', route('admin.countries.index'))
							
							@slot('context', 'danger')
							
							Delete country
						@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
