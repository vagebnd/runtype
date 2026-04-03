<?php

namespace Vagebond\Runtype\Tests\Fakes\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Vagebond\Runtype\Tests\Fakes\Models\Product;

/** @mixin Product */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'category' => $this->whenLoaded('category', fn () => new CategoryResource($this->category)),
            'features' => $this->whenLoaded('features', fn () => FeatureResource::collection($this->features)),
        ];
    }
}
