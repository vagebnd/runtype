<?php

namespace Vagebond\Runtype\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;
use Vagebond\Runtype\RuntypeServiceProvider;
use Vagebond\Runtype\Tests\Fakes\Models\Category;
use Vagebond\Runtype\Tests\Fakes\Models\Feature;
use Vagebond\Runtype\Tests\Fakes\Models\Product;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->buildWorld();
    }

    private function buildWorld()
    {
        Product::factory()
            ->for(Category::factory())
            ->has(Feature::factory())
            ->create();
    }

    protected function getPackageProviders($app)
    {
        return [
            RuntypeServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        config()->set('database.default', 'testing');
        config()->set('runtype.auto_discover_paths', [__DIR__.'/Fakes/Resources']);

        $this->migrateDatabase();
    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    public function migrateDatabase()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->string('name');
            $table->timestamps();
        });
    }
}
