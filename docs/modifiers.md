# Modifiers

Modifiers enable you to set properties on a resource or model that we can't detect automatically.

Consider the following example:

```php
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Feature */
class FeatureResource extends JsonResource
{
    public $showHiddenData = false;

    public function toArray($request)
    {
        return [
            ...
            'hidden' => $this->when($this->showHiddenData, false),
        ];
    }
}
```

The `hidden` property is only visible when `$showHiddenData` is set to `true`. We can't detect this automatically, so we need to use a modifier.

See this example:

```php
class FeatureModifier implements Modifiable
{
    public function modify($instance)
    {
        $instance->showHiddenData = true;

        return $instance;
    }
}
```

We can now use the modifier in the config file:

```php
'modifiers' => [
    FeatureResource::class => FeatureModifier::class,
],
```

And now the `hidden` property will be visible in the generated type.

```typescript
export interface ProductResourceType {
    ...
    hidden?: boolean;
}
```

## Creating a custom modifier

You can create your own modifier by implementing the `Vagebond\Runtype\Contracts\Modifiable` interface.

```php
class MyModifier implements Modifiable
{
    public function modify($instance)
    {
        // do something with the instance
    }
}
```
