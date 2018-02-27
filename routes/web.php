<?php

use Laravel\Lumen\Routing\Router;

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

$router->get('/', function () {
    return app()->version();
});

// Generate random string
$router->get('appKey', function () {
    return str_random('32');
});

$router->group(['middleware' => 'auth:api'], function () use ($router) {
    $router->get('users', 'UserController@index');
    $router->get('users/{id}', 'UserController@showUser');
	$router->get('profile/{id}', 'ProfileController@showProfile');
    $router->put('users/{id}', 'UserController@updateUser');
    $router->delete('users/{id}', 'UserController@deleteUser');
});


$router->group(['prefix' => 'customers', 'middleware' => 'auth:api'], function () use ($router) {
    $router->post('users', 'UserController@createUser');
});

$router->group(['prefix' => 'physio', 'middleware' => 'auth:api'], function () use ($router) {
    $router->post('users', 'UserController@createPhysio');
});