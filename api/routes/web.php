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

$router->group(['prefix' => 'api/v1', 'middleware' => 'auth'], function () use ($router) {
    $router->group(['prefix' => 'customer'], function () use ($router) {
        $router->get('', 'CustomerController@index');
        $router->post('', 'CustomerController@create');
        $router->get('{id}', 'CustomerController@get');
        $router->put('{id}', 'CustomerController@update');
        $router->delete('{id}', 'CustomerController@destroy');
    });

    $router->group(['prefix' => 'account'], function () use ($router) {
        $router->get('', 'AccountController@index');
        $router->post('', 'AccountController@create');
        $router->get('{id}', 'AccountController@get');
        $router->put('{id}', 'AccountController@update');
        $router->delete('{id}', 'AccountController@destroy');
    });

    $router->group(['prefix' => 'transaction'], function () use ($router) {
        $router->get('', 'TransactionController@index');
        $router->get('{accountId}/account', 'TransactionController@listByAccount');
        $router->post('', 'TransactionController@create');
        $router->get('{id}', 'TransactionController@get');
        $router->put('{id}', 'TransactionController@update');
        $router->delete('{id}', 'TransactionController@destroy');
    });
});
