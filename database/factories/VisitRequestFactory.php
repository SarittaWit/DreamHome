<?php

namespace Database\Factories;

use App\Models\VisitRequest;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitRequestFactory extends Factory
{
    protected $model = VisitRequest::class;

    public function definition(): array
    {
        return [
            'property_id' => Property::inRandomOrder()->first()->id ?? 1,
            'client_name' => $this->faker->name(),
            'client_phone' => $this->faker->phoneNumber(),
            'scheduled_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled', 'completed']),
            'message' => $this->faker->sentence(10),
        ];
    }
}

