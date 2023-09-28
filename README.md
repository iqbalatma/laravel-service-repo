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
use Illuminate\Pagination\LengthAwarePaginator;

class UserService extends BaseService
{

    public function getAllDataPaginated():LengthAwarePaginator
    {
        return UserRepository::getAllDataPaginated();
    }
}
```

> [!NOTE]
> Here is example call repository via non-static method
```php
<?php

namespace App\Services\Management;

use Iqbalatma\LaravelServiceRepo\BaseService;
use App\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService extends BaseService
{

    public function getAllDataPaginated():LengthAwarePaginator
    {
        return (new UserRepository())->getAllDataPaginated();
    }
}
```


### Predefined Method Query
You can call predefied method from service. Here is list of predefined method query and it's use case.
```php
<?php
function getAllDataPaginated(array $whereClause = [], array $columns = ["*"]);
function getAllData(array $whereClause = [], array $columns = ["*"]);
function getDataById(string|int|array $id, array $columns = ["*"]);
function getSingleData(array $whereClause = [], array $columns = ["*"]);
function addNewData(array $requestedData);
function updateDataById(string|int $id, array $requestedData, array $columns = ["*"], bool $isReturnObject = true);
function updateDataByWhereClause(array $whereClause, array $requestedData, array $columns = ["*"], bool $isReturnObject = false);
function deleteDataById(string|int $id);
function deleteDataByWhereClause(array $whereClause);
```

You can also chaining method before predefined method query.

```php
<?php
function with(array|string $relations);
function without(array|string $relations);
function withAvg(array|string $relation, string $column);
function withCount(mixed $relations);
function withMin(array|string $relation, string $column);
function withMax(array|string $relation, string $column)
function withSum(array|string $relation, string $column);
function has(Relation|string $relation, string $operator = '>=', int $count = 1, string $boolean = 'and', Closure|null $callback = null);
function whereHas(string $relation, Closure|null $callback = null, string $operator = '>=', int $count = 1);

and other method ....
```


> [!NOTE]
> Here is how to use predefined method with chaining method for additional query

```php
<?php

namespace App\Services\Management;

use Iqbalatma\LaravelServiceRepo\BaseService;
use App\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService extends BaseService
{

    public function getAllDataPaginated():LengthAwarePaginator
    {
        return UserRepository::with('profile')->getAllDataPaginated();
    }
}
```

### How to add predefined method
You can also create your own method on repository. For example you want to create query that will be execute in many place and want to avoid redundant code.

> [!IMPORTANT]
> Create predefined method query with ***query*** prefix. So you can call statically **without** query prefix.
> Example : UserRepository::getAllActiveUser()
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

    public function queryGetAllActiveUser(){
          return $this->builder->where('status', 'active')->get();
    }
}
```

