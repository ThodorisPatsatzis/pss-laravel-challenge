<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SectorFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->domainWord;

        return [
            'name' => $name,
        ];
    }
}
