<?php

function route_class()
{
    return str_replace('.', '_', Route::currentRouteName());
}

function get_db_config()
{
    if (getenv('IS_IN_HEROKU')) {
        $url = parse_url(getenv("DATABASE_URL"));

        return $db_config = [
            'connection' => 'pgsql',
            'host' => $url["host"],
            'database'  => substr($url["path"], 1),
            'username'  => $url["user"],
            'password'  => $url["pass"],
        ];
    } else {
        return $db_config = [
            'connection' => env('DB_CONNECTION', 'mysql'),
            'host' => env('DB_HOST', 'localhost'),
            'database'  => env('DB_DATABASE', 'forge'),
            'username'  => env('DB_USERNAME', 'forge'),
            'password'  => env('DB_PASSWORD', ''),
        ];
    }
}

function category_nav_active($category_id)
{
    return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
}

function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}

function model_link($title, $model, $prefix = '')
{
    // Get the complex serpentine name of the data model
    $model_name = model_plural_name($model);

    // Initialization prefix
    $prefix = $prefix ? "/$prefix/" : '/';

    // Use site URL to stitch the full URL
    $url = config('app.url') . $prefix . $model_name . '/' . $model->id;

    // Stitch the HTML A tag and return
    return '<a href="' . $url . '" target="_blank">' . $title . '</a>';
}

function model_plural_name($model)
{
    // Get full class name from the entity, for example: App\Models\User
    $full_class_name = get_class($model);

    // Get the base class name, for example: pass the parameter 'App\Models\User' will get 'User'
    $class_name = class_basename($full_class_name);

    // Snake-shaped naming, for example: Passing 'User' will get 'user', 'FooBar' will get 'foo_bar'
    $snake_case_name = snake_case($class_name);

    // Get the plural form of the substring, for example: pass the parameter 'user' will get 'users'
    return str_plural($snake_case_name);
}
