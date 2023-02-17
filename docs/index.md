# Introduction

This package allow you to convert Laravel Models & Resources into Typescript interfaces.

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

will be converted into this interface:

```typescript
export interface ProductResourceType {
    id: number;
    name: string;
    hidden?: boolean;
}
```
