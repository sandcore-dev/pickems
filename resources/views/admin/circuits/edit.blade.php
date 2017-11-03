@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route( 'circuits.update', [ 'circuits' => $circuit->id ] ) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $circuit->name) }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('length') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Length (meter)</label>

                            <div class="col-md-6">
                                <input id="name" type="number" min="1" class="form-control" name="length" value="{{ old('length', $circuit->length) }}" required>

                                @if ($errors->has('length'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('length') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">City</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="city" value="{{ old('city', $circuit->city) }}" required>

                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('area') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Area</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="area" value="{{ old('area', $circuit->area) }}">

                                @if ($errors->has('area'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('area') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('country_id') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Country</label>

                            <div class="col-md-6">
                                <select id="name" class="form-control" name="country_id" required>
		                        @foreach( $countries as $country )
		                        	<option value="{{ $country->id }}"{{ old('country_id', $circuit->country_id) == $country->id ? ' selected' : '' }}>{{ $country->name }}</option>
		                        @endforeach
                                </select>

                                @if ($errors->has('country_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('country_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Edit circuit
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
