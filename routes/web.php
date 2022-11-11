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
    return $router->app->version();
});

// añadimos prefijo api
$router->group(['prefix' => 'api'], function () use ($router) {
    // rutas de sessión
    $router->post('logout', [
        'middleware' => 'logout',
        'as' => 'logout', 'uses' => 'AuthController@logout',
    ]);

    $router->post('refresh', [
        'middleware' => 'refresh',
        'as' => 'refresh', 'uses' => 'AuthController@refresh',
    ]);

    $router->post('login', [
        'middleware' => 'login',
        'as' => 'login', 'uses' => 'AuthController@login',
    ]);

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->group(['prefix' => 'regions'], function () use ($router) {
            $router->get('/', [
                'as' => 'regions.index', 'uses' => 'RegionController@index',
            ]);
        });

        $router->group(['prefix' => 'communes'], function () use ($router) {
            $router->get('/', [
                'as' => 'communes.index', 'uses' => 'CommuneController@index',
            ]);
        });

        $router->group(['prefix' => 'customers'], function () use ($router) {
            $router->get('/', [
                'as' => 'customers.index', 'uses' => 'CustomerController@index',
            ]);
            $router->post('/create', [
                'middleware' => 'validateCustomer:create',
                'as' => 'customers.store', 'uses' => 'CustomerController@store',
            ]);
            $router->get('/{dniOrEmail}', [
                'middleware' => 'validateCustomer:show',
                'as' => 'customers.show', 'uses' => 'CustomerController@show',
            ]);
            $router->delete('/{dniOrEmail}', [
                'middleware' => 'validateCustomer:destroy',
                'as' => 'customers.destroy', 'uses' => 'CustomerController@destroy',
            ]);
        });
    });
});
