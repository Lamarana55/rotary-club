<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    RoleController,
    UtilisateurController,
};

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

//Route::post('login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'auth.jwt',
], function ($router) {

    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('profile', [AuthController::class, 'udpatePhoto']);
    //Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    //Utilisateurs
    Route::post('user', [UtilisateurController::class, 'save']);
    Route::get('users/{terme?}', [UtilisateurController::class, 'index']);
    Route::get('user/{id}', [UtilisateurController::class, 'edit']);
    Route::put('user/{id}', [UtilisateurController::class, 'update']);
    Route::put('updatePassword', [UtilisateurController::class, 'updatePassword']);
    Route::get('userBySession', [UtilisateurController::class, 'userBySession']);
    Route::post('updatePhoto', [UtilisateurController::class, 'updatePhoto']);

    //Roles
    Route::post('role', [RoleController::class, 'save']);
    Route::get('roles/{terme?}', [RoleController::class, 'index']);
    Route::get('role/{id}', [RoleController::class, 'edit']);
    Route::put('role/{id}', [RoleController::class, 'update']);
    Route::get('roleRelation', [RoleController::class, 'roleRelation']);
    Route::post('assignRole', [RoleController::class, 'assignRole']);
});
