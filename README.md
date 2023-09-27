# Laravel Service Repository

Laravel Service Repository is laravel package for service repository pattern. Service repository pattern helps you to separate concern and move logic into service class. From service class you can query all of your data from repository, not directly using model. This will help you to avoid redundant query and make it easier to maintain.

## Upcomming
- Customize root of filter and order by config
- Publish service stub for customization
- Testing
- type hint for predefined method on repository extend


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
This repository already have some predefined query, but you are free to customize predefined query as you need

<img width="1211" alt="Screenshot 2023-09-28 at 00 55 06" src="https://github.com/iqbalatma/laravel-service-repo/assets/35129050/cdd0c078-a83c-4002-bae6-d21ab03ff932">



## Service


## Repository
Use repository to query your database via model. So you do not need to write same query twice. You can create repository on directroy App/Repositories. 
Here is example of UserRepository

https://excalidraw.com/#room=24e719b796d8b6e68bca,NNkRKYkFtcOlWIjFZu3wPA

```php
<?php

namespace App\Repositories;

use App\Models\User;
use Iqbalatma\LaravelServiceRepo\BaseRepository;

class UserRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new User();
    }
}
```

You can create your own custom method query on UserRepository and you can also use base method on BaseRepository.

This is the example of using method get all data paginated. 
```php
<?php
use App\Repositories\UserRepository;

$repository = new UserRepository();

$repository->getAllDataPaginated(["category" => "band"], ["id", "name", "email"]);

```

You can also use filter with query parameters. You can call method filter column. This is for first argument.
The structure of request would be like this
```php
[
   "filter" => [
       "user_name" => [
           "value" => "iqbal",
           "operator" => "like"
       ]
   ]
]
````
For operator, default value is `=` but if you want to use other operator you can change it with `>=`, `>`, `!=`, `<`, `<=`.
You can defined the column name the map with the column name on table.
```php
use App\Repositories\UserRepository;

$repository = new UserRepository();

$repository->filterColumn(["user_name" => "users.name"])->getAllDataPaginated(["category" => "band"], ["id", "name", "email"]);
```
Parameter filter column receive 2 arguments, first argumen used for filter the repository model (the current model that belongs to the repository). For example, UserRepository using model User, that means first argumen is for used for filtering user column. Second argumen is used for filtering on relation with model User.
Request query param on filter array is depends on query that allowed on first argument. For example allowed key is user_name, that's mean you can query with this key. Value of user_name on first param is for column on table database, you can use users.name with table name users, or just call name. 
Use table name is recommended to avoid ambiguous name.
