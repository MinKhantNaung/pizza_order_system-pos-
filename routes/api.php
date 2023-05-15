<?php

use App\Http\Controllers\Api\RouteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products/list', [RouteController::class, 'productList']);
Route::get('/categories/list', [RouteController::class, 'categoryList']);
Route::get('/contacts/list', [RouteController::class, 'contactList']);
Route::get('/users/list', [RouteController::class, 'userList']);
Route::post('/categories/create', [RouteController::class, 'categoryCreate']);
Route::post('/contacts/create', [RouteController::class, 'contactCreate']);
Route::get('/categories/delete/{id}', [RouteController::class, 'categoryDelete']);

Route::get('/categories/detail/{id}', [RouteController::class, 'categoryDetail']);
Route::post('/categories/update', [RouteController::class, 'categoryUpdate']);

/*
    categories List
    localhost:8000/api/categories/list

    products list
    localhost:8000/api/products/list

    contacts list
    localhost:8000/api/contacts/list

    users list
    localhost:8000/api/users/list
*/
