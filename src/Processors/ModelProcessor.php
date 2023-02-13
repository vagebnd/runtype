<?php

namespace Vagebond\Runtype\Processors;

use Illuminate\Database\Eloquent\Model;
use Vagebond\Runtype\Actions\ListModelRelations;
use Vagebond\Runtype\Contracts\Processable;

class ModelProcessor implements Processable
{
    public function process(string $model)
    {
        $model = app($model);

        $relations = app(ListModelRelations::class)->handle($model);

        /** @var Model $instance */
        $instance = $model::first()
            ->with($relations)
            ->first();

        return $instance;
    }
}
