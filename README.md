# Laravel Service Repository

Laravel Service Repository is laravel package for service repository pattern. Service repository pattern helps you to separate concern and move logic into service class. From service class you can query all of your data from repository, not directly using model. This will help you to avoid redundant query and make it easier to maintain.

## Upcomming
- [ ] Customize root of filter and order by config
- [ ] Publish service stub for customization
- [ ] Testing
- [ ] Type hint for predefined method on repository extend


## How to install
Use composer to install Laravel Service Repository Package

```
composer require iqbalatma/laravel-service-repo
```

## Concept
Here is concept of service repository, you can see diagram below
Controller will handle only http request and http response. This will make your controller thin.
All of data from request will be validate on Validation class. All validation rule will be defined here
After all data validated, data will be passed to service. In service, all of business logic works.
Every business logic that need data or modify data from database will be communicate via repository.
This repository already have some predefined query, but you are free to customize predefined query as you need.

<img width="1211" alt="Screenshot 2023-09-28 at 00 55 06" src="https://github.com/iqbalatma/laravel-service-repo/assets/35129050/cdd0c078-a83c-4002-bae6-d21ab03ff932">



## Service
Service is use for your business logic. You can call service from controller or from another service. This package have base service and you can extend to this service. You can also generate service via artisan command.

```
php artisan make:service UserService
```
This command will generate service for you in ***App/Services*** directory.


## Repository
Use repository to query your database via model. So you do not need to write same query twice. You can generate repository on directroy ***App/Repositories*** via artisan command. 

```
php artisan make:repository UserRepository
```
This command will generate repository for you in ***App/Repositories*** directory
Here is example of UserRepository.

```php
<?php

namespace App\Repositories;
use Iqbalatma\LaravelServiceRepo\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

class UserRepository extends BaseRepository
{

     /**
     * use to set base query builder
     * @return Builder
     */
    public function getBaseQuery(): Builder
    {
        return User::query();
    }

    /**
     * use this to add custom query on filterColumn method
     * @return void
     */
    public function applyAdditionalFilterParams(): void
    {
    }
}
```
### How to call repository from service
You can call method on repository via static or non-static method.

> [!NOTE]
> Here is example call repository via static method
```php
<?php

namespace App\Services\Management;

use Iqbalatma\LaravelServiceRepo\BaseService;
use App\Repositories\UserRepository;


class UserService extends BaseService
{

    public function getAllDataPaginated():LengthAwarePaginator
    {
        return UserRepository::getAllDataPaginated();
    }
}
```

