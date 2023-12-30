<?php

use App\Modules\Permissions\Http\Controllers\PermissionController;
use App\Modules\Permissions\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Route::get('/permissions',[PermissionController::class, 'index'])->name('permissions.index');

Route::resource('permissions', PermissionController::class);
Route::resource('users', UserController::class);
