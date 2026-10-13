
<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\DestinationController;
use Illuminate\Support\Facades\Route;

// HOME
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// EXPLORE
Route::get('/explore', [ExploreController::class, 'index'])
    ->name('explore');

// DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

// ITINERARY
Route::get('/itinerary', [ItineraryController::class, 'index'])
    ->name('itinerary');

// DESTINATION DETAIL - HAKIM
Route::get('/destinations/{slug}', [DestinationController::class, 'show'])
    ->name('destinations.show');

// FAVORITE - HAKIM
Route::view('/favorites', 'favorites.index')
    ->name('favorites.index');
