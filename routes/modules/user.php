<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('can:admin_access')->group(fn() => Route::resource('user', UserController::class));