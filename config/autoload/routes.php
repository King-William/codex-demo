<?php

declare(strict_types=1);

use Hyperf\HttpServer\Router\Router;

Router::addGroup('/boss', static function (): void {
    Router::post('/login', 'App\\Controller\\BossAuthController@login');

    Router::addGroup('/foods', static function (): void {
        Router::get('', 'App\\Controller\\FoodController@index');
        Router::get('/{id:\\d+}', 'App\\Controller\\FoodController@show');
        Router::post('', 'App\\Controller\\FoodController@store');
        Router::put('/{id:\\d+}', 'App\\Controller\\FoodController@update');
        Router::delete('/{id:\\d+}', 'App\\Controller\\FoodController@destroy');
    });
});
