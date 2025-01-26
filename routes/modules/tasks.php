<?php

use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group( function(){
    Route::resource('tasks', TasksController::class);
    Route::get('users/search', [TasksController::class, 'searchUsers'])->name('users.search');

});