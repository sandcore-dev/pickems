@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route( 'series.update', [ 'series' => $series->id ] ) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

			@component('admin.form.input')
				@slot('field', 'name')
				
				@slot('value', $series->name)
				
				@slot('label', 'Name')
				
				@slot('attributes')
					required autofocus
				@endslot
			@endcomponent

			@component('admin.form.submit')
				@slot('cancel', route('series.index'))
				
				Edit series
			@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
