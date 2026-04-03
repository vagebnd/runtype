<?php

namespace Vagebond\Runtype\Tests\Fakes\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Vagebond\Runtype\Tests\Fakes\Models\Feature;

/** @mixin Feature */
class FeatureResource extends JsonResource
{
    public $showHiddenData = false;

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
            'computedAttribute' => $this->computedAttribute,
            'hidden' => $this->when($this->showHiddenData, false),
        ];
    }
}
