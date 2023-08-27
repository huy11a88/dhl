<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [OrderController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::view('/register', 'register')->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::resource('orders', OrderController::class);
Route::get('/orders/review/{order}', [ReviewController::class, 'getByOrderId'])->name('reviews.show');

Route::group(['middleware' => 'auth'], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::post('/orders/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::group(['middleware' => 'role:3'], function () {
        Route::post('/orders/apply/{order}', [OrderController::class, 'applyOrder'])->name('orders.apply');
        Route::get('/my-shipping-orders', [OrderController::class, 'myShippingOrders'])->name('my-shipping-orders');
        Route::post('/orders/update-status', [OrderController::class, 'updateOrderStatus'])->name('orders.update-status');
    });

    Route::post('/new-message', [ChatController::class, 'newMessage']);
    Route::get('/chat-message/{user}', [ChatController::class, 'getByUserId']);

    Route::get('/customer-service', [ChatController::class, 'customerService'])->name('customer-service');
});