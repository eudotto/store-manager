<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return "is alive";
});

$router->post('/authorization/token', 'AuthorizationController@makeToken');
$router->post('/register', 'AuthorizationController@register');

$router->group(['prefix' => 'api/v1', 'middleware' => 'auth'], function () use ($router) {
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->get('', 'UserController@index');
        $router->post('', 'UserController@create');
        $router->get('{id}', 'UserController@get');
        $router->put('{id}', 'UserController@update');
        $router->delete('{id}', 'UserController@destroy');
    });

    $router->group(['prefix' => 'store'], function () use ($router) {
        $router->get('', 'StoreController@index');
        $router->post('', 'StoreController@create');
        $router->get('{id}', 'StoreController@get');
        $router->put('{id}', 'StoreController@update');
        $router->delete('{id}', 'StoreController@destroy');
    });
});
