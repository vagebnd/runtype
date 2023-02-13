<?php

namespace Vagebond\Runtype\Tests\Fakes\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \Vagebond\Runtype\Tests\Fakes\Models\Product */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
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
