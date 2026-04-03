<?php

namespace Vagebond\Runtype\Tests\Fakes\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Vagebond\Runtype\Tests\Fakes\Models\Category;

/**
 * @extends Factory<Model>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
        ];
    }
}
