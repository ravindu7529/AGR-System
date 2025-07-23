<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RedemptionController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\ItemController;

// --- Public routes (no auth needed) ---

// filepath: /Applications/XAMPP/xamppfiles/htdocs/ChauffeurGuide_RewardPlatform/routes/api.php
Route::get('/test', function () {
    return 'test';
});
// Guide login
Route::post('/guide/login', [AuthController::class, 'guideLogin']);

// Admin login
Route::post('/admin/login', [AuthController::class, 'adminLogin']);

// --- Protected routes for guides ---
Route::middleware(['auth:sanctum'])->group(function () {

    // Guide dashboard
    Route::get('/guide/{id}/dashboard', [GuideController::class, 'show']);

    // Redeem points
    Route::post('/guides/{guide_id}/redeem', [RedemptionController::class, 'store']);
    
    // Redeem cash
    Route::post('/guides/{guide_id}/redeem-cash', [RedemptionController::class, 'redeemCash']);
});


// --- Protected routes for admins ---
Route::middleware(['auth:sanctum'])->group(function () {
    
    // Admin guide management
    Route::post('/admin/guides', [GuideController::class, 'store']);
    Route::put('/admin/guides/{id}', [GuideController::class, 'update']);
    Route::delete('/admin/guides/{id}', [GuideController::class, 'destroy']);
    Route::post('admin/visits', [VisitController::class, 'store'])->name('admin.addVisit');
    Route::post('/admin/items', [ItemController::class, 'store']);
    Route::get('/admin/items', [ItemController::class, 'index']);
    Route::put('/admin/items/{id}', [ItemController::class, 'update']);
    Route::delete('/admin/items/{id}', [ItemController::class, 'destroy']);

    Route::get('/admin/guides', [GuideController::class, 'index']);
    Route::get('/admin/guides/{id}', [GuideController::class, 'show']);
    Route::get('/admin/guides/{id}/redemption', [RedemptionController::class, 'show']);
    Route::get('/admin/guide/search', [SearchController::class, 'guide']);
    Route::get('/test-query', function (\Illuminate\Http\Request $request) {
        return response()->json(['q' => $request->input('q')]);
    });

     // Redemption approval routes for admin
    Route::get('/admin/redemption-requests', [RedemptionController::class, 'getPendingRequests']);
    Route::post('/admin/redemption-requests/{id}/approve', [RedemptionController::class, 'approveRequest']);

    Route::get('/admin/cash-redemption-requests', [RedemptionController::class, 'getPendingCashRequests']);
    Route::post('/admin/cash-redemption-requests/{id}/approve', [RedemptionController::class, 'approveCashRequest']);

    // Admin updates visit and tourist count
    Route::post('/admin/guides/{id}/update-activity', [AdminController::class, 'updateActivity']);
    Route::get('/admin/dashboard-stats', [AdminController::class, 'getDashboardStats']);
    Route::get('/admin/report/pdf', [AdminController::class, 'generatePDFReport']);
    Route::get('/admin/report/excel', [AdminController::class, 'generateExcelReport']);
    Route::get('/admin/guides', [AdminController::class, 'getGuides']);
});

// --- Public route to create an admin ---
Route::post('/admin/register', [AdminController::class, 'store']);