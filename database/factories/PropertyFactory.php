<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'location' => $this->faker->city(),
            'price' => $this->faker->numberBetween(500000, 3000000),
            'status' => $this->faker->randomElement(['active', 'pending', 'sold', 'rented']),
        ];
    }
}
