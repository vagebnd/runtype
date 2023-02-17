# Processors

We use processors to determine how we should process a given entity.
Let's illustrate this with an example.

Because RunType generates types at runtime, we need to know how to process a given entity.
By default, RunType ships with 3 processors:

- `DefaultProcessor` (which is used for all entities that don't have a specific processor)
- `ModelProcessor` (which is used for all entities that extend `Illuminate\Database\Eloquent\Model`)
- `ResourceProcessor` (which is used for all entities that extend `Illuminate\Http\Resources\Json\JsonResource`)

In the config file, you can specify which processor should be used for a given entity.

```php
<?php

/**
 * Indicate how you would like your entities to be processed
 * you can choose a subclass or an interface
 */
'processors' => [
    JsonResource::class => ResourceProcessor::class,
    Model::class => ModelProcessor::class,
],
```

To enable resource processing, we need to know which Model is used by the resource.
This is done by using the `@mixin` annotation.

::: warning @mixin
The `@mixin` annotation is required for the `ResourceProcessor` to work.
:::

```php
<?php

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Product */
class ProductResource extends JsonResource
```

We will use the mixin to determine which model is used by the resource and create and instance of this model
and put it through the resource.

## Creating a custom processor

You can create your own processor by implementing the `Vagebond\Runtype\Contracts\Processable` interface.

```php
<?php

class MyProcessor implements Processable
{
    public function process($entity): array
    {
        // do something with the entity
    }
}
```

You can then use your processor in the config file.

```php
<?php

'processors' => [
    MyProcessor::class => MyProcessor::class,
],
```
