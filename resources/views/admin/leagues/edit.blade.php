@extends('admin.index')

@section('title', 'Edit league - Admin -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route( 'admin.leagues.update', [ 'leagues' => $league->id ] ) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        
			@component('admin.form.input')
				@slot('field', 'name')
				
				@slot('label', 'Name')
				
				@slot('value', $league->name)
				
				@slot('attributes')
					required autofocus
				@endslot
			@endcomponent
			
			@component('admin.form.input')
				@slot('field', 'series')
				
				@slot('label', 'Series')
				
				@slot('value', $league->series->name)
				
				@slot('attributes')
					disabled
				@endslot
			@endcomponent

			@component('admin.form.submit')
				@slot('cancel', route( 'admin.leagues.index' ))
				
				Edit league
			@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
