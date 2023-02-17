# Converters

Converters are responsible for converting a given entity into a Typescript type.

RunType ships with 3 converters:
- `DefaultConverter` (which is used for all entities that don't have a specific converter)
- `ModelConverter` (which is used for all entities that extend `Illuminate\Database\Eloquent\Model`)
- `ResourceConverter` (which is used for all entities that extend `Illuminate\Http\Resources\Json\JsonResource`)

In the config file, you can specify which converter should be used for a given entity.

```php
<?php

/**
 * Indicate how you would like your entities to be converted
 * into Typescript types
 */
'converters' => [
    JsonResource::class => ResourceConverter::class,
    Model::class => ModelConverter::class,
],
```

## Creating a custom converter

You can create your own converter by extending the `Vagebond\Runtype\Converters\AbstractConverter` class.

```php
<?php

use Vagebond\Runtype\Values\TypescriptType;

class MyConverter extends AbstractConverter
{
    public function handle($instance): TypescriptType
    {
        // do something with the entity
    }
}
```
