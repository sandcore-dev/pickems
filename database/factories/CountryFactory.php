<?php

namespace Database\Factories;

use App\Country;
use Countries;
use Illuminate\Database\Eloquent\Factories\Factory;
use Monarobase\CountryList\CountryNotFoundException;

class CountryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Country::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->countryCode,
            'name' => function (array $attributes) {
                try {
                    return Countries::getOne($attributes['code'], config('app.locale'));
                } catch (CountryNotFoundException $e) {
                    return '(random)' . $this->faker->country;
                }
            },
        ];
    }
}
