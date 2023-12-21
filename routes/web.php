<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(SubscriptionController::class)->middleware('auth')->group(function(){
    Route::get('/add-subscriptions', 'addSubscriptions')->name('addSubscriptions');
    Route::post('/create-subscription', 'createSubscription')->name('createSubscription');
    Route::get('/subscriptions-list', 'list')->name('list');
    Route::get('showSubscription/{id}', 'show')->name('showSubscription');
    Route::put('/activateSubscription/{id}', 'activate')->name('activateSubscription');
 });

require __DIR__.'/auth.php';