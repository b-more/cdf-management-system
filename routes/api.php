<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\FundController;
use App\Http\Controllers\Api\SmsController;
use App\Http\Controllers\Api\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/auth/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {

    // User authentication
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/auth/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);

    // Projects API
    Route::prefix('projects')->group(function () {
        Route::get('/', [ProjectController::class, 'index']);
        Route::post('/', [ProjectController::class, 'store']);
        Route::get('/{id}', [ProjectController::class, 'show']);
        Route::put('/{id}', [ProjectController::class, 'update']);
        Route::delete('/{id}', [ProjectController::class, 'destroy']);

        // Project-specific actions
        Route::post('/{id}/recommend', [ProjectController::class, 'recommend']);
        Route::post('/{id}/approve', [ProjectController::class, 'approve']);
        Route::post('/{id}/reject', [ProjectController::class, 'reject']);
        Route::get('/{id}/timeline', [ProjectController::class, 'timeline']);
        Route::post('/{id}/monitoring-report', [ProjectController::class, 'addMonitoringReport']);
    });

    // Disaster Projects API
    Route::prefix('disaster-projects')->group(function () {
        Route::get('/', [ProjectController::class, 'disasterIndex']);
        Route::post('/', [ProjectController::class, 'storeDisaster']);
        Route::get('/{id}', [ProjectController::class, 'showDisaster']);
        Route::put('/{id}', [ProjectController::class, 'updateDisaster']);
        Route::delete('/{id}', [ProjectController::class, 'destroyDisaster']);
    });

    // Fund Management API
    Route::prefix('funds')->group(function () {
        Route::get('/allocations', [FundController::class, 'allocations']);
        Route::post('/allocations', [FundController::class, 'createAllocation']);
        Route::put('/allocations/{id}', [FundController::class, 'updateAllocation']);
        Route::post('/allocations/{id}/disburse', [FundController::class, 'disburse']);

        Route::get('/grants', [FundController::class, 'grants']);
        Route::post('/grants', [FundController::class, 'createGrant']);
        Route::post('/grants/{id}/repayment', [FundController::class, 'recordRepayment']);
        Route::get('/grants/{id}/repayments', [FundController::class, 'getRepayments']);
    });

    // SMS API
    Route::prefix('sms')->group(function () {
        Route::post('/send', [SmsController::class, 'sendSingle']);
        Route::post('/send-bulk', [SmsController::class, 'sendBulk']);
        Route::get('/notifications', [SmsController::class, 'getNotifications']);
        Route::post('/notifications/{id}/retry', [SmsController::class, 'retry']);
        Route::get('/statistics', [SmsController::class, 'getStatistics']);
    });

    // Reports API
    Route::prefix('reports')->group(function () {
        Route::get('/dashboard', [ReportController::class, 'dashboard']);
        Route::get('/projects-summary', [ReportController::class, 'projectsSummary']);
        Route::get('/funds-summary', [ReportController::class, 'fundsSummary']);
        Route::get('/ward-performance', [ReportController::class, 'wardPerformance']);
        Route::get('/export/projects', [ReportController::class, 'exportProjects']);
        Route::get('/export/funds', [ReportController::class, 'exportFunds']);
    });

    // Wards API
    Route::prefix('wards')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\WardController::class, 'index']);
        Route::get('/{id}', [App\Http\Controllers\Api\WardController::class, 'show']);
        Route::get('/{id}/projects', [App\Http\Controllers\Api\WardController::class, 'projects']);
        Route::get('/{id}/statistics', [App\Http\Controllers\Api\WardController::class, 'statistics']);
    });

    // Monitoring Reports API
    Route::prefix('monitoring')->group(function () {
        Route::get('/reports', [App\Http\Controllers\Api\MonitoringController::class, 'index']);
        Route::post('/reports', [App\Http\Controllers\Api\MonitoringController::class, 'store']);
        Route::get('/reports/{id}', [App\Http\Controllers\Api\MonitoringController::class, 'show']);
        Route::put('/reports/{id}', [App\Http\Controllers\Api\MonitoringController::class, 'update']);
    });

    // Documents API
    Route::prefix('documents')->group(function () {
        Route::post('/upload', [App\Http\Controllers\Api\DocumentController::class, 'upload']);
        Route::get('/{id}/download', [App\Http\Controllers\Api\DocumentController::class, 'download']);
        Route::delete('/{id}', [App\Http\Controllers\Api\DocumentController::class, 'delete']);
    });
});

// Public API routes (no authentication required)
Route::prefix('public')->group(function () {
    Route::get('/projects', [ProjectController::class, 'publicIndex']);
    Route::get('/projects/{id}', [ProjectController::class, 'publicShow']);
    Route::get('/statistics', [ReportController::class, 'publicStatistics']);
    Route::get('/wards', [App\Http\Controllers\Api\WardController::class, 'publicIndex']);
});

// Webhook routes (for SMS delivery reports, etc.)
Route::prefix('webhooks')->group(function () {
    Route::post('/sms-delivery', [SmsController::class, 'deliveryReport']);
    Route::post('/payment-callback', [FundController::class, 'paymentCallback']);
});
