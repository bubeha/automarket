<?php

use Illuminate\Contracts\Routing\Registrar;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


/**
 * @var Registrar $router
 */

$router->group([
    'prefix' => 'auth',
], static function (Registrar $router) {
    $router->post('login', 'Auth\AuthController@login');
    $router->post('logout', 'Auth\AuthController@logout');
    $router->post('refresh', 'Auth\AuthController@refresh');
    $router->post('me', 'Auth\AuthController@me');
});

$router->group([
    'middleware' => 'auth:api',
], static function (Registrar $router) {

});
