<?php

namespace Vagebond\Runtype\Tests\Fakes\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Vagebond\Runtype\Tests\Fakes\Models\Feature;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FeatureFactory extends Factory
{
    protected $model = Feature::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_id' => 1,
            'name' => fake()->name(),
        ];
    }
}
