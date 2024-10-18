<?php

namespace Database\Factories;

use App\Models\Sector;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company,
            'address' => fake()->unique()->address,
            'email' => fake()->unique()->email,
            'website' => fake()->unique()->url,
            'number_of_employees' => rand(1, 1000),
            'user_id' => User::factory()->make()->id,
            'sector_id' => Sector::factory()->make()->id,
        ];
    }
}
