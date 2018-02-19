@extends('admin.index')

@section('title', __('Delete entry') . ' - ' . __('Admin') . ' -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route( 'admin.entries.destroy', [ 'entries' => $entry->id ] ) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <div class="form-group text-center">
							@lang('Do you want to delete the entry :entry with driver :driver at :team from the season :season of the series :series?', [ 'entry' => '<strong>' . $entry->car_number . '</strong>', 'driver' => '<strong>' . $entry->driver->fullName . '</strong>', 'team' => '<strong>' . $entry->team->name . '</strong>', 'season' => '<strong>' . $entry->season->name . '</strong>', 'series' => '<strong>' . $entry->season->series->name . '</strong>' ])
                        </div>

						@component('admin.form.submit')
							@slot('cancel', route( 'admin.entries.index', [ 'entries' => $entry->season->id ] ))
							
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
