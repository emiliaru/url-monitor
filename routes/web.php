<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteController;

Route::get('/', function () {
    return redirect()->route('websites.index');
});

Route::resource('websites', WebsiteController::class);
Route::post('websites/{website}/check', [WebsiteController::class, 'check'])->name('websites.check');
