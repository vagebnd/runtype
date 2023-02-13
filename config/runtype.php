<?php

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Vagebond\Runtype\Converters\ModelConverter;
use Vagebond\Runtype\Converters\ResourceConverter;
use Vagebond\Runtype\Processors\ModelProcessor;
use Vagebond\Runtype\Processors\ResourceProcessor;

return [
    /**
     * The paths where runtype will look for resources
     */
    'auto_discover_paths' => [
        app_path('Http/Resources'),
    ],

    /**
     * Indicate how you would like your entities to be processed
     * you can choose a subclass or an interface
     */
    'processors' => [
        JsonResource::class => ResourceProcessor::class,
        Model::class => ModelProcessor::class,
    ],

    /**
     * Indicate how you would like your entities to be converted
     * into Typescript types
     */
    'converters' => [
        JsonResource::class => ResourceConverter::class,
        Model::class => ModelConverter::class,
    ],

    /**
     * There are certain situations where runtype can't determine the
     * required settings for a resource, i.e. when conditionally loading attributes,
     * You can use a modifier to set the required settings on your model so our
     * resource generator can detect them.
     */
    'modifiers' => [
        // 'App\Models\MyModel' => 'App\Modifiers\MyModelModifier',
    ],

    /*
     * In your classes, you sometimes have types that should always be replaced
     * by the same TypeScript representations. For example, you can replace a
     * Datetime always with a string. You define these replacements here.
     */

    'type_replacements' => [
        DateTime::class => 'string',
        DateTimeImmutable::class => 'string',
        // CarbonImmutable::class => 'string',
        Carbon::class => 'string',
    ],

    /**
     * runtype will write the generated Typescript to this file
     */
    'output_file' => resource_path('types/runtype.d.ts'),
];
