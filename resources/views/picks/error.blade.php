@extends('layouts.app')

@section('title', 'Picks -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
                <div class="alert alert-warning">
                    {{ $error }}
                </div>
        </div>
    </div>
</div>

@endsection
