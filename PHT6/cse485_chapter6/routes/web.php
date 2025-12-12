<?php
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// TODO 12: Thêm 2 route này
Route::get('/', [PageController::class, 'showHomepage']);
Route::get('/about', [PageController::class, 'showHomepage']);