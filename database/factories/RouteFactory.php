<?php

namespace Database\Factories;

use App\Models\Airport;
use App\Models\Route;
use Illuminate\Database\Eloquent\Factories\Factory;

class RouteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Route::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'airline' => $this->faker->name,
            'airline_id' => $this->faker->name,
            'source_airport' => $this->faker->name,
            'source_airport_id' => function() {
                return Airport::factory()->create()->id;
            },
            'destination_airport' => $this->faker->name,
            'destination_airport_id' => function () {
                return Airport::factory()->create()->id;
            },
            'stops' => 0,
            'equipment' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 1, 5000),
        ];
    }
}
