@extends('layouts.app')

@section('title', __('Rules') . ' -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        
        @switch($locale)
			@case('nl')
				@include('rules.nl')
			@break
			
			@case('en')
			@default
				@include('rules.en')
        @endswitch
    
        </div>
    </div>
</div>
@endsection
