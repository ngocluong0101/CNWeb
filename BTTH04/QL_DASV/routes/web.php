<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IssueController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::resource('issues', IssueController::class);

Route::get('/', [IssueController::class, 'index'])->name('issues.index');

Route::resource('issues', IssueController::class);