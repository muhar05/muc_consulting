<?php

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

use Illuminate\Support\Facades\Route;
use Modules\Proposal\Http\Controllers\ProposalController;

Route::prefix('proposal')->group(function() {
    Route::get('/index', [ProposalController::class, 'index'])->name('proposal.index');
    Route::get('/create', [ProposalController::class, 'create'])->name('proposal.create');
    Route::post('/', [ProposalController::class, 'store'])->name('proposal.store');
    // Tambahkan route lain jika perlu (edit, update, destroy, show)
});