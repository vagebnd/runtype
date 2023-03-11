# Introduction

This package allows you to generate Typescript interfaces from your Laravel Models & Resources.

This resource:

```php
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Product */
class ProductResource extends JsonResource
{
    public $showHiddenData = false;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'hidden' => $this->when($this->showHiddenData, false),
        ];
    }
}

```

will generate this Typescript interface:

```typescript
export interface ProductResourceType {
    id: number;
    name: string;
    hidden?: boolean;
}
```
