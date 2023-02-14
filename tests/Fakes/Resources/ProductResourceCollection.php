<?php

namespace Vagebond\Runtype\Tests\Fakes\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/** @mixin \Vagebond\Runtype\Tests\Fakes\Models\Product */
class ProductResourceCollection extends ResourceCollection
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
            'data' => $this->collection,
        ];
    }
}
