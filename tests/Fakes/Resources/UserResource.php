<?php

namespace Vagebond\Runtype\Tests\Fakes\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \Vagebond\Runtype\Tests\Fakes\Models\User */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'can' => [
                'edit' => $request->user()->can('edit', $this->resource),
            ],
        ];
    }
}
