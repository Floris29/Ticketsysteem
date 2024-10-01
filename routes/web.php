<?php

use App\Http\Controllers\EventsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

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
    return view('base');
})->name('home');

Route::get('/events',  [PagesController::class, 'events'])->name('events');

Route::get('events/{id}/order', [\App\Http\Controllers\TicketsController::class, 'order'])
    ->middleware(['auth'])
    ->name('events.orderticket');

Route::get('/events/{order_id}/confirmOrder', [OrderController::class, 'confirmOrder'])
    ->name('events.confirmOrder')
    ->middleware('auth');

Route::post('events/{id}/order', [\App\Http\Controllers\TicketsController::class, 'store'])
    ->middleware(['auth'])
    ->name('events.storeOrderTicket');

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function() {
    Route::resource('events', EventsController::class);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
