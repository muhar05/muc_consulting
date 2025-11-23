<?php
use Modules\Timesheet\Http\Controllers\TimesheetController;
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

Route::prefix('timesheet')->group(function() {
    Route::get('/', [TimesheetController::class, 'index'])->name('timesheet.index');
    Route::get('/index', [TimesheetController::class, 'index']);
    Route::get('/create', [TimesheetController::class, 'create'])->name('timesheet.create');
    Route::post('/', [TimesheetController::class, 'store'])->name('timesheet.store');
    Route::get('/{id}/edit', [TimesheetController::class, 'edit'])->name('timesheet.edit');
    Route::put('/{id}', [TimesheetController::class, 'update'])->name('timesheet.update');
    Route::delete('/{id}', [TimesheetController::class, 'destroy'])->name('timesheet.destroy');
});