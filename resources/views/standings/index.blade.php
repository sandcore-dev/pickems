@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            
		@include('standings.dropdown')
    
        </div>
    </div>
</div>

@include('standings.list')

@endsection
