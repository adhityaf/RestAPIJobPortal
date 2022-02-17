<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => rand(1, 3),
            'job_id' => rand(1, 3),
            'attachment' => $this->faker->words(7, true),
            'status' => $this->faker->randomElement(['sent', 'interview', 'offered', 'hired', 'unsuitable']),
        ];
    }
}
