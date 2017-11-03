<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
	/**
	* Bootstrap any application services.
	*
	* @return void
	*/
	public function boot()
	{
		Schema::defaultStringLength(191);
		
		Validator::extend('gte', function ($attribute, $value, $parameters, $validator) {
			if( !isset($parameters[0]) )
				return;
			
			$data			= $validator->getData();
			$referencedValue	= $data[ $parameters[0] ];
			
			return $value >= $referencedValue;
		});
		
		Validator::replacer('gte', function ($message, $attribute, $rule, $parameters) {
			return str_replace('_', ' ', "The value of $attribute should be greater than or equal to {$parameters[0]}.");
		});
	}

	/**
	* Register any application services.
	*
	* @return void
	*/
	public function register()
	{
		//
	}
}
