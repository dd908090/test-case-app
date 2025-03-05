<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id" => User::inRandomOrder("id")->first()->id,
            "original_url"=> $this->faker->url,
            "short_url"=> Str::random(10),
            "expired_at"=> $this->faker->dateTimeBetween('now', '+2 year'),
        ];
    }
}
