<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('registrations.create');

Route::post('/registrations', [RegistrationController::class, 'store'])
    ->name('registrations.store');
