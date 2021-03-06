<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     * @noinspection PhpUnusedParameterInspection
     */
    public function boot()
    {
        Paginator::useBootstrapThree();

        Schema::defaultStringLength(191);

        Validator::extend(
            'gte',
            function ($attribute, $value, $parameters, $validator) {
                if (!isset($parameters[0])) {
                    return null;
                }

                $data = $validator->getData();
                $referencedValue = $data[$parameters[0]];

                return $value >= $referencedValue;
            }
        );

        Validator::replacer(
            'gte',
            function ($message, $attribute, $rule, $parameters) {
                return str_replace(
                    '_',
                    ' ',
                    "The value of $attribute should be greater than or equal to {$parameters[0]}."
                );
            }
        );

        Blade::directive(
            'routeActive',
            function ($regex) {
                return "<?php echo preg_match( $regex, Route::currentRouteName() ) ? 'active' : ''; ?>";
            }
        );
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
