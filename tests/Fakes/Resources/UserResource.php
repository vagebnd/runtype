<?php

namespace Vagebond\Runtype\Tests\Fakes\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Vagebond\Runtype\Tests\Fakes\Models\User;

/** @mixin User */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array|Arrayable|\JsonSerializable
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
