<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Destination>
 */
class DestinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->city(),
            'description' => $this->faker->paragraph(3),
            'price' => $this->faker->randomFloat(2, 50, 1000),
            'duration' => $this->faker->numberBetween(3, 21),
            'image' => null,
        ];
    }
}