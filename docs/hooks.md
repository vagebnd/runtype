# Hooks

Hooks allow you to add custom logic to the generation process.

A hook has 2 methods: `before` and `after`. The `before` method is called before the generation process starts. The `after` method is called after the generation process is finished.

## Using a hook

You can use a hook in the config file:

```php
'hooks' => [
    MyHook::class,
],
```

## Creating a hook

You can create your own hook by implementing the `Vagebond\Runtype\Contracts\Hookable` interface.

```php
class MyHook implements Hookable
{
    public function before()
    {
        // do something before the generation process starts
    }

    public function after()
    {
        // do something after the generation process is finished
    }
}
```

## When to use a hook

There are instances when your resources depend on a logged in user or a specific tenant. In these cases you can use a hook to setup the environment before the generation process starts.

```php
class SetupEnvironmentHook implements Hookable
{
    public function before()
    {
        $user = User::first();
        $tenant = Tenant::first();

        Auth::login($user);
        Tenant::setTenant($tenant);
    }

    public function after()
    {
        Auth::logout();
        Tenant::clearTenant();
    }
}
```
