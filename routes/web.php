<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\RedemptionController;
use App\Http\Controllers\VisitController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/guide/login', function () {
    return view('guide.login');
});
Route::get('/guide/dashboard/{id}', function () { 
    return view('guide.dashboard'); 
});
Route::post('/guide/redeem', [RedemptionController::class, 'redeem']);


Route::get('/admin/login', function () {
    return view('admin.login');
});
Route::get('admin/add-guide', function () {
    return view('admin.addguide');
});
Route::get('admin/add-item', function () {
    return view('admin.additem');
});
Route::get('admin/guide/{id}/update', function () {
    return view('admin.update');
});
Route::get('/admin/dashboard', [GuideController::class, 'dashboard']);
Route::get('/admin/update/item', function () {
    return view('admin.updateitem');
});


// Route::get('/login', function () {
//     return view('Admin.login'); // or your login view
// })->name('login');