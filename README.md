# Laravel Service Repository

Laravel Service Repository is laravel package for service repository pattern. Service repository pattern helps you to separate concern and move logic into service class. From service class you can query all of your data from repository, not directly using model. This will help you to avoid redundant query and make it easier to maintain.


## Install
Use composer to install Laravel Service Repository Package

```
composer require iqbalatma/laravel-service-repo
```

## Repository
Use repository to query your database via model. So you do not need to write same query twice. You can create repository on directroy App/Repositories. 
Here is example of UserRepository

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

