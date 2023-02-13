<?php

namespace Vagebond\Runtype\Tests\Fakes\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \Vagebond\Runtype\Tests\Fakes\Models\Feature */
class FeatureResource extends JsonResource
{
    public $showHiddenData = false;

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
            'computedAttribute' => $this->computedAttribute,
            'hidden' => $this->when($this->showHiddenData, false),
        ];
    }
}
