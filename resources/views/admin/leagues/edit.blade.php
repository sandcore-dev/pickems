@extends('admin.index')

@section('title', __('Edit league') . ' - ' . __('Admin') . ' -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <form class="form-horizontal" method="POST" action="{{ route( 'admin.leagues.update', [ 'league' => $league->id ] ) }}">
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

						@if( $league->access_token )
							@component('admin.form.input')
								@slot('field', 'invite_url')

								@slot('label', 'Invitation URL')

								@slot('value', route('invite', [ 'token' => $league->access_token ]))

								@slot('attributes')
									readonly
								@endslot
							@endcomponent
						@endif

						@component('admin.form.checkbox')
							@slot('field', 'generate_token')

							@slot('label', 'Generate a (new) access token')
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
