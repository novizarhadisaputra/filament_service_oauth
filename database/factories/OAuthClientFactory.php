<?php

namespace Database\Factories;

use App\Models\OAuthClient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OAuthClient>
 */
class OAuthClientFactory extends Factory
{
    protected $model = OAuthClient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'client_id' => Str::random(40),
            'name' => $this->faker->company(),
            'client_secret' => Str::random(40),
            'provider' => 'users',
            'redirect_uris' => $this->faker->url(),
            'grant_types' => 'password,authorization_code',
            'revoked' => false,
        ];
    }
}
