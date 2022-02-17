<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->words(5, true);
        return [
           'title' => $title,
           'slug' => Str::slug($title),
           'description' => $this->faker->text(100),
           'status' => $this->faker->randomElement(['open', 'close']),
           'type' => $this->faker->randomElement(['permanent', 'contract', 'internship']),
           'level' => $this->faker->randomElement(['entry', 'mid', 'senior']),
        ];
    }
}
