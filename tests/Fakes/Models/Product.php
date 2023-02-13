<?php

namespace Vagebond\Runtype\Tests\Fakes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Vagebond\Runtype\Tests\Fakes\Factories\ProductFactory;

class Product extends Model
{
    use HasFactory;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function features(): HasMany
    {
        return $this->hasMany(Feature::class);
    }

    public static function newFactory()
    {
        return ProductFactory::new();
    }
}
