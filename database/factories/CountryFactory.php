<?php

namespace Database\Factories;

use App\Models\Country;
use Countries;
use Illuminate\Database\Eloquent\Factories\Factory;
use Monarobase\CountryList\CountryNotFoundException;

class CountryFactory extends Factory
{
    protected $model = Country::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->countryCode,
            'name' => function (array $attributes) {
                try {
                    return Countries::getOne($attributes['code'], config('app.locale'));
                } catch (CountryNotFoundException $e) {
                    return '(random) ' . $this->faker->country;
                }
            },
        ];
    }
}
