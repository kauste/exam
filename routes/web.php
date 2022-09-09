<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// back
Route::middleware('role:admin')->group(function () {
    Route::get('/restaurant', [RestaurantController::class, 'index'])->name('restaurants-list');
    Route::get('/restaurant/create', [RestaurantController::class, 'create'])->name('restaurant-create');
    Route::post('/restaurant/store', [RestaurantController::class, 'store'])->name('restaurant-store');
    Route::get('/restaurant/edit/{restaurant}', [RestaurantController::class, 'edit'])->name('restaurant-edit');
    Route::put('/restaurant/update/{restaurant}', [RestaurantController::class, 'update'])->name('restaurant-update');
    Route::delete('/restaurant/delete/{restaurant}', [RestaurantController::class, 'destroy'])->name('restaurant-delete');

    Route::get('/menu', [MenuController::class, 'index'])->name('menu-list');
    Route::get('/menu/create', [MenuController::class, 'create'])->name('menu-create');
    Route::post('/menu/store', [MenuController::class, 'store'])->name('menu-store');
    Route::get('/menu/edit/{menu}', [MenuController::class, 'edit'])->name('menu-edit');
    Route::put('/menu/update/{menu}', [MenuController::class, 'update'])->name('menu-update');
    Route::delete('/menu/delete/{menu}', [MenuController::class, 'destroy'])->name('menu-delete');
    
    Route::get('/dish', [DishController::class, 'index'])->name('dish-list');
    Route::get('/dish/create', [DishController::class, 'create'])->name('dish-create');
    Route::post('/dish/store', [DishController::class, 'store'])->name('dish-store');
    Route::get('/dish/edit/{dish}', [DishController::class, 'edit'])->name('dish-edit');   
    Route::delete('/dish/delete/{dish}', [DishController::class, 'destroy'])->name('dish-delete');

    Route::get('/back-order-list', [OrderController::class, 'backOrder'])->name('back-order-list');
    Route::put('/change-state/{id}', [OrderController::class, 'changeState'])->name('change-state');
    
});
Route::put('/dish/update/{dish}', [DishController::class, 'update'])->name('dish-update')->middleware('role:admin');

//front
Route::middleware('role:user')->group(function () {
    Route::get('/front-restaurant', [FrontController::class, 'restaurantList'])->name('front-restaurant-list');
    Route::get('/restaurant-menu/{restaurant}', [FrontController::class, 'restaurantMenu'])->name('restaurant-menu');
    Route::post('/add-to-cart/{dishId}/{restaurantId}', [OrderController::class, 'addToCart'])->name('add-to-cart');
    Route::get('/show-cart', [OrderController::class, 'showCart'])->name('show-cart');
    Route::post('/order', [OrderController::class, 'order'])->name('order');
    Route::get('/order-list', [OrderController::class, 'orderList'])->name('order-list');
    Route::delete('/client-delete-order/{id}', [OrderController::class, 'clientDeleteOrder'])->name('client-delete-order');
    Route::get('/client-edit-order/{id}', [OrderController::class, 'clientEditOrder'])->name('client-edit-order');
    Route::delete('/order-item-delete/{orderId}/{dishId}', [OrderController::class, 'orderItemDelete'])->name('order-item-delete');
    Route::put('/edit-amounts', [OrderController::class, 'editAmounts'])->name('edit-amounts');
});
Auth::routes();



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
