@extends('admin.index')

@section('title', __('Edit team') . ' - ' . __('Admin') . ' -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <form class="form-horizontal" method="POST" action="{{ route( 'admin.teams.update', [ 'team' => $team->id ] ) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

						@component('admin.form.input')
							@slot('field', 'name')

							@slot('value', $team->name)

							@slot('label', 'Name')

							@slot('attributes')
								required autofocus
							@endslot
						@endcomponent

						@component('admin.form.select')
							@slot('field', 'country_id')

							@slot('value', $team->country_id)

							@slot('label', 'Country')

							@slot('options', $countries)
						@endcomponent

						@component('admin.form.checkbox')
							@slot('field', 'active')

							@slot('value', $team->active)

							@slot('label', 'Active')
						@endcomponent

						@component('admin.form.submit')
							@slot('cancel', route('admin.teams.index'))

							Edit team
						@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
