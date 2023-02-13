<?php

namespace Vagebond\Runtype\Tests\Fakes\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Vagebond\Runtype\Tests\Fakes\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'product name',
            'category_id' => 1,
        ];
    }
}
