<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Per Page
    |--------------------------------------------------------------------------
    |
    | This is use to tell our repository on get all paginated method that default
    | per page is 10
    |
    */
    "perpage" => 15,

    /*
    |--------------------------------------------------------------------------
    | Model root namespace
    |--------------------------------------------------------------------------
    |
    | This is used for base namespace for model on repository
    |
    */
    "model_root_namespace" => "App\\Models",

    /*
    |--------------------------------------------------------------------------
    | Target repository dir
    |--------------------------------------------------------------------------
    |
    | This is used for target directory place for generated repository
    |
    */
    "target_repository_dir" => "app/Repositories",

    /*
    |--------------------------------------------------------------------------
    | Target service dir
    |--------------------------------------------------------------------------
    |
    | This is used for target directory place for generated service
    |
    */
    "target_service_dir" => "app/Services",


];
