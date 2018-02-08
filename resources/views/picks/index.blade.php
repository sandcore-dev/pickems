@extends('layouts.app')

@section('title', 'Picks -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            
			@include('picks.dropdown')
    
        </div>
    </div>
</div>

@include('picks.grid')

@endsection
