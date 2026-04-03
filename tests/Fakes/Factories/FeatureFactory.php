<?php

namespace Vagebond\Runtype\Tests\Fakes\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Vagebond\Runtype\Tests\Fakes\Models\Feature;

/**
 * @extends Factory<Model>
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
