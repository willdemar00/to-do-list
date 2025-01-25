<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'home');


require __DIR__.'/auth.php';
require __DIR__.'/modules/home.php';
require __DIR__.'/modules/profile.php';
