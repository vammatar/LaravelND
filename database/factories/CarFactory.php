<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Car;
use Faker\Generator as Faker;

class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Car::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $manufacturers = ['Toyota', 'Honda', 'Ford', 'Nissan', 'Dacia', 'BMW', 'Mercedes', 'Audi', 'Hyundai', 'Kia'];
        $models = ['Camry', 'Civic', 'Fiesta', 'Micra', 'Sandero', 'X1', 'B-Class', 'A6', 'I-30', 'Sportage'];
        $licensePlate = $this->faker->bothify('???###');

        return [
            'manufacturer' => $this->faker->randomElement($manufacturers),
            'model' => $this->faker->randomElement($models),
            'license_plate' => strtoupper($licensePlate),
        ];
        }
};
