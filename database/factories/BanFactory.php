<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ban>
 */
class BanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::all()->random()->id,
            'admin_id' => \App\Models\User::where('role', 'admin')->get()->random()->id,
            'reason' => $this->faker->sentence,
            'ban_start' => now(),
            'ban_end' => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
