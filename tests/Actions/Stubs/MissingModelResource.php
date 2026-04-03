<?php

namespace Vagebond\Runtype\Tests\Actions\Stubs;

use Illuminate\Http\Resources\Json\JsonResource;
use Vagebond\Runtype\Tests\Fakes\Models\MissingModel;

/** @mixin MissingModel */
class MissingModelResource extends JsonResource {}
