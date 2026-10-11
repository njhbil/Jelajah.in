<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItineraryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/explore', [ExploreController::class, 'index'])->name('explore');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/itinerary', [ItineraryController::class, 'index'])->name('itinerary');