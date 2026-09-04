<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\TaskModerationController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $user = request()->user();

    if ($user?->hasRole(['admin', 'super_admin'])) {
        return redirect()->route('admin.dashboard');
    }

    if ($user?->hasRole('moderator')) {
        return redirect()->route('admin.tasks.index');
    }

    return view('public.guest');
})->name('guest');

Route::get('/about', [PublicPageController::class, 'about'])->name('about');
Route::get('/capabilities', [PublicPageController::class, 'capabilities'])->name('capabilities');
Route::get('/capabilities/{capability}', [PublicPageController::class, 'capability'])->name('capabilities.show');
Route::get('/blog', [PublicPageController::class, 'blog'])->name('blog.index');
Route::get('/blog/{post}', [PublicPageController::class, 'post'])->name('blog.show');
Route::get('/terms', [PublicPageController::class, 'terms'])->name('terms');
Route::get('/sitemap.xml', [PublicPageController::class, 'sitemap'])->name('sitemap');
Route::get('/google-site-verification.html', [PublicPageController::class, 'verification'])->name('google.verification');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
});

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminLoginController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'store'])->middleware('throttle:5,1')->name('admin.login.store');
});

Route::middleware(['auth', 'role:admin,super_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/stats', [AdminController::class, 'stats'])->name('admin.stats');

    Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('admin.users.update');
    Route::post('/users/{user}/suspend', [UserManagementController::class, 'suspend'])->name('admin.users.suspend');
    Route::post('/users/{user}/unsuspend', [UserManagementController::class, 'unsuspend'])->name('admin.users.unsuspend');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
    Route::delete('/users/{user}/role/{role}', [UserManagementController::class, 'removeRole'])->name('admin.users.role.remove');

});

Route::middleware(['auth', 'role:super_admin'])->prefix('admin')->group(function () {
    Route::get('/settings', [AdminSettingsController::class, 'edit'])->name('admin.settings.index');
    Route::put('/settings', [AdminSettingsController::class, 'update'])->name('admin.settings.update');
});

Route::middleware(['auth', 'role:super_admin'])->prefix('admin')->group(function () {
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('admin.audit-logs.index');
    Route::get('/audit-logs/export', [AuditLogController::class, 'export'])->name('admin.audit-logs.export');
});

Route::middleware(['auth', 'role:admin,super_admin,moderator'])->prefix('admin')->group(function () {
    Route::get('/tasks', [TaskModerationController::class, 'index'])->name('admin.tasks.index');
    Route::delete('/tasks/{task}', [TaskModerationController::class, 'deleteTask'])->name('admin.tasks.delete');
    Route::patch('/tasks/{task}/restore', [TaskModerationController::class, 'restore'])->withTrashed()->name('admin.tasks.restore');
    Route::put('/tasks/{task}/status', [TaskModerationController::class, 'updateStatus'])->name('admin.tasks.status');
    Route::put('/tasks/{task}/reassign', [TaskModerationController::class, 'reassignTask'])->name('admin.tasks.reassign');
    Route::post('/tasks/bulk-action', [TaskModerationController::class, 'bulkAction'])->name('admin.tasks.bulk-action');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
