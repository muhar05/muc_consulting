<?php
use Modules\Serviceused\Http\Controllers\ServiceusedController;
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

Route::prefix('serviceused')->group(function() {
    Route::get('/index', [ServiceusedController::class, 'index'])->name('serviceused.index');
    Route::get('/create', [ServiceusedController::class, 'create'])->name('serviceused.create');
    Route::post('/', [ServiceusedController::class, 'store'])->name('serviceused.store');
    Route::get('/{id}/edit', [ServiceusedController::class, 'edit'])->name('serviceused.edit');
    Route::put('/{id}', [ServiceusedController::class, 'update'])->name('serviceused.update');
    Route::delete('/{id}', [ServiceusedController::class, 'destroy'])->name('serviceused.destroy');
});