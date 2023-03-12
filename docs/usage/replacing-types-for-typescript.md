# Type replacements

In your PHP classes, you sometimes have types that should always be replaced by the same TypeScript interface. For example, you can replace a Datetime always with a string. You define these replacements in your config file.

```php
return [
    // ...
    'type_replacements' => [
        DateTime::class => 'string',
        DateTimeImmutable::class => 'string',
        Carbon::class => 'string',
        BensampoEnum::class => 'string',
    ],
];
```
