@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route('leagues.store') }}">
                        {{ csrf_field() }}
                        
			@component('admin.form.input')
				@slot('field', 'name')
				
				@slot('label', 'Name')
				
				@slot('attributes')
					required autofocus
				@endslot
			@endcomponent
			
			@component('admin.form.select')
				@slot('field', 'series[]')
				
				@slot('label', 'Series')
				
				@slot('options', $series);
				
				@slot('attributes')
					required multiple size="10"
				@endslot
			@endcomponent
			
			@component('admin.form.submit')
				@slot('cancel', route( 'leagues.index' ) )
				
				Add league
			@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
