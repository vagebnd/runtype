<?php

namespace Vagebond\Runtype\Tests\Fakes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Vagebond\Runtype\Tests\Fakes\Factories\CategoryFactory;

class Category extends Model
{
    use HasFactory;

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public static function newFactory()
    {
        return CategoryFactory::new();
    }
}
