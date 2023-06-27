<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Car;
use App\Models\Owner;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Owner>
 */
class OwnerFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'=>fake()->firstName(),
            'surname'=>fake()->lastName(),
            'year'=>rand(1920,2005)
        ];
    }

    public function hasCars($count = null)
    {
        return $this->state(function (array $attributes) use ($count) {
            return [];
        })
        ->afterCreating(function (Owner $owner) use ($count) {
            $owner->cars()->createMany(
                Car::factory()->count(rand(1, 3))->make()->toArray()
            );
        });
    }
}
