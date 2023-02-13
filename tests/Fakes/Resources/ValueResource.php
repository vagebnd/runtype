<?php

namespace Vagebond\Runtype\Tests\Fakes\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \Vagebond\Runtype\Tests\Fakes\Values\TestValue */
class ValueResource extends JsonResource
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
            'name' => $this->name,
            'value' => $this->value,
        ];
    }
}
