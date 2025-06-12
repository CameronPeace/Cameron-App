<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShortUrl>
 */
class ShortUrlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $domainOptions = ['example.com', 'sleep.net', 'whitehouse.gov.com', 'myspace.com'];
        $redirectOptions = ['www.google.com', 'dmv.gov', 'brave.com', 'twitch.tv'];

        return [
            'domain' => fake()->randomElement($domainOptions),
            'code' => fake()->regexify('[A-Za-z0-9]{5}'),
            'redirect' => fake()->randomElement($redirectOptions),
        ];
    }
}
