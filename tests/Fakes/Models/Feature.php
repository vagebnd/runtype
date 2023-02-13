<?php

namespace Vagebond\Runtype\Tests\Fakes\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Vagebond\Runtype\Tests\Fakes\Factories\FeatureFactory;

class Feature extends Model
{
    use HasFactory;

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function computedAttribute(): Attribute
    {
        return new Attribute(get: fn () => 'computed');
    }

    public static function newFactory()
    {
        return FeatureFactory::new();
    }
}
