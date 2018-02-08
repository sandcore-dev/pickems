@extends('admin.index')

@section('title', 'Add league - Admin -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route('admin.leagues.store') }}">
                        {{ csrf_field() }}
                        
						@component('admin.form.input')
							@slot('field', 'name')
							
							@slot('label', 'Name')
							
							@slot('attributes')
								required autofocus
							@endslot
						@endcomponent
						
						@component('admin.form.select')
							@slot('field', 'series_id')
							
							@slot('label', 'Series')
							
							@slot('options', $series);
							
							@slot('attributes')
								required
							@endslot
						@endcomponent
						
						@component('admin.form.checkbox')
							@slot('field', 'generate_token')
							
							@slot('label', 'Generate an access token')
						@endcomponent

						@component('admin.form.submit')
							@slot('cancel', route( 'admin.leagues.index' ) )
							
							Add league
						@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
