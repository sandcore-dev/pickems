@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route( 'entries.destroy', [ 'entries' => $entry->id ] ) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <div class="form-group text-center">
                        	Do you want to delete the entry <strong>{{ $entry->car_number }}</strong> with driver <strong>{{ $entry->driver->fullName }}</strong> at <strong>{{ $entry->team->name }}</strong><br>
                        	from the season <strong>{{ $entry->season->name }}</strong> of the series <strong>{{ $entry->season->series->name }}</strong>?
                        </div>

			@component('admin.form.submit')
				@slot('cancel', route( 'entries.index', [ 'entries' => $entry->season->id ] ))
				
				@slot('context', 'danger')
				
				Delete entry
			@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
