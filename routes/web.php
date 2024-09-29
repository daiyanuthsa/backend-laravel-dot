<?php

use App\Http\Controllers\Dashboard\BookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::redirect('/', '/dashboard');

Route::get('/dashboard', function () {
    return view('pages.dashboard-books');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('book')->group(function () {
        Route::get('/', [BookController::class, 'index'])->name('book');
        Route::get('/create', [BookController::class, 'create'])->name('book-create');
    });

});
require __DIR__ . '/auth.php';
