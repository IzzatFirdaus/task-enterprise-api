<?php

use App\Http\Controllers\Admin\AdminAnalyticsController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\TaskModerationController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tasks', TaskController::class)->except(['create', 'edit']);
});

Route::post('/admin/login', [AdminAuthController::class, 'login'])->middleware('throttle:5,1');

Route::middleware(['auth:sanctum', 'role:admin,super_admin', 'throttle:60,1'])->group(function () {
    Route::get('/admin/users', [UserManagementController::class, 'apiIndex']);
    Route::get('/admin/users/{user}', [UserManagementController::class, 'apiShow']);
    Route::put('/admin/users/{user}', [UserManagementController::class, 'apiUpdate']);
    Route::delete('/admin/users/{user}', [UserManagementController::class, 'apiDestroy']);
    Route::post('/admin/users/{user}/suspend', [UserManagementController::class, 'apiSuspend'])->middleware('throttle:10,1');
    Route::post('/admin/users/{user}/unsuspend', [UserManagementController::class, 'apiUnsuspend'])->middleware('throttle:10,1');
    Route::post('/admin/users/{user}/roles/{role}', [UserManagementController::class, 'apiAssignRole'])->middleware('throttle:20,1');
    Route::delete('/admin/users/{user}/roles/{role}', [UserManagementController::class, 'apiRemoveRole'])->middleware('throttle:20,1');

    Route::get('/admin/analytics/dashboard', [AdminAnalyticsController::class, 'dashboard']);
    Route::get('/admin/analytics/users', [AdminAnalyticsController::class, 'users']);
    Route::get('/admin/analytics/tasks', [AdminAnalyticsController::class, 'tasks']);

    Route::middleware(['role:super_admin', 'throttle:30,1'])->group(function () {
        Route::get('/admin/audit-logs', [AuditLogController::class, 'apiIndex']);
        Route::get('/admin/audit-logs/{auditLog}', [AuditLogController::class, 'apiShow']);
        Route::get('/admin/audit-logs/export', [AuditLogController::class, 'apiExport']);

        Route::get('/admin/settings', [AdminSettingsController::class, 'apiIndex']);
        Route::put('/admin/settings', [AdminSettingsController::class, 'apiUpdate']);
    });
});

Route::middleware(['auth:sanctum', 'role:moderator,admin,super_admin', 'throttle:60,1'])->group(function () {
    Route::get('/admin/tasks', [TaskModerationController::class, 'apiIndex']);
    Route::get('/admin/tasks/{task}', [TaskModerationController::class, 'apiShow']);
    Route::put('/admin/tasks/{task}', [TaskModerationController::class, 'apiReassign']);
    Route::delete('/admin/tasks/{task}', [TaskModerationController::class, 'apiDelete']);
    Route::post('/admin/tasks/bulk-action', [TaskModerationController::class, 'apiBulkAction'])->middleware('throttle:20,1');
});
