<?php

namespace Vagebond\Runtype\Tests\Fakes\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Vagebond\Runtype\Tests\Fakes\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => fake()->password(),
            'email_verified_at' => now(),
            'remember_token' => fake()->password(),
        ];
    }
}
