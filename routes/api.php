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
    'middleware' => 'guest',
    'namespace' => 'Auth',
], static function (Registrar $router) {
    /** @uses \App\Http\Controllers\Auth\AuthController::login() */
    $router->post('login', 'AuthController@login');
});

$router->group([
    'middleware' => 'auth:api',
], static function (Registrar $router) {
    $router->group([
        'prefix' => 'auth',
        'namespace' => 'Auth',
    ], static function (Registrar $router) {
        /** @uses \App\Http\Controllers\Auth\AuthController::getAccountData() */
        $router->get('user', 'AuthController@getAccountData');
        /** @uses \App\Http\Controllers\Auth\AuthController::logout() */
        $router->post('logout', 'AuthController@logout');
        /** @uses \App\Http\Controllers\Auth\AuthController::refreshToken() */
        $router->post('refresh', 'AuthController@refreshToken');
    });
});
