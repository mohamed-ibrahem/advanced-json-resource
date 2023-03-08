# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mohamed-ibrahem/advanced-json-resource.svg?style=flat-square)](https://packagist.org/packages/mohamed-ibrahem/advanced-json-resource)
[![Total Downloads](https://img.shields.io/packagist/dt/mohamed-ibrahem/advanced-json-resource.svg?style=flat-square)](https://packagist.org/packages/mohamed-ibrahem/advanced-json-resource)
[![run-tests](https://github.com/mohamed-ibrahem/advanced-json-resource/actions/workflows/run-tests.yml/badge.svg)](https://github.com/mohamed-ibrahem/advanced-json-resource/actions/workflows/run-tests.yml)

Create an advanced json responses for your Laravel application by creating a method for every response type, For example ```toIndex```, ```toShow```, ```toForm```, or a custom method name! Also you have ```shared``` method for all shared attributes.

## Installation

You can install the package via composer:

```bash
composer require mohamed-ibrahem/advanced-json-resource 
```

### Usage

Every resource should extends the ```AdvancedJsonResponse\ApiResource``` class.

Now based on your response type you can create the methods.
And in the controller call these methods in snake case without ```to``` in the beginning.

### Example

```php

use AdvancedJsonResource\ApiResource;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @mixin User
 */
class UserResource extends ApiResource
{
    /**
     * {@inheritdoc}
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toIndex(Request $request): array
    {
        return [
            'name' => $this->name,
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toShow(Request $request): array
    {
        return [
            'email' => $this->email,
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toForm(Request $request): array
    {
        return [
            'can_update' => true,
        ];
    }

    /**
     * This is a custom response method.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toCustom(Request $request): array
    {
        return [
            'custom' => 'custom',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function shared(Request $request): array
    {
        return [
            'id' => $this->id,
        ];
    }
}

```

In the controller:

```php
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController
{
    public function index(): UserResource
    {
        return UserResource::index(
            User::all(),
        );
    }

    public function store(Request $request): UserResource
    {
        //...

        return UserResource::form($user);
    }

    public function show(User $user): UserResource
    {
        return UserResource::show($user);
    }

    public function custom(Request $request, User $user): UserResource
    {
        return UserResource::cutsom($user);
    }
}

```

### Testing

```bash
composer test
```

## Credits

-   [Mohamed Ibrahim](https://github.com/mohamed-ibrahim)
-   [All Contributors](../../contributors)
