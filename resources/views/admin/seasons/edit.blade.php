@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route( 'seasons.update', [ 'seasons' => $season->id ] ) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group">
                            <label for="series" class="col-md-4 control-label">Series</label>

                            <div class="col-md-6">
                                <input id="series" type="text" class="form-control" name="series" value="{{ $season->series->name }}" disabled>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('start_year') ? ' has-error' : '' }}">
                            <label for="start_year" class="col-md-4 control-label">Start year</label>

                            <div class="col-md-6">
                                <input id="start_year" type="number" min="1970" class="form-control" name="start_year" value="{{ old('start_year', $season->start_year) }}" required autofocus>

                                @if ($errors->has('start_year'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('start_year') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('end_year') ? ' has-error' : '' }}">
                            <label for="end_year" class="col-md-4 control-label">End year</label>

                            <div class="col-md-6">
                                <input id="end_year" type="number" min="1970" class="form-control" name="end_year" value="{{ old('end_year', $season->end_year) }}" required>

                                @if ($errors->has('end_year'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('end_year') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Edit season
                                </button>
                                
                                <a class="btn btn-default" href="{{ route( 'seasons.index', [ 'series' => $season->series->id ] ) }}">Cancel</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
