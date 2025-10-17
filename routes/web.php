<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PlanController as AdminPlanController;
use App\Http\Controllers\Admin\LimitController as AdminLimitController;
use App\Http\Controllers\Admin\GatewayController as AdminGatewayController;
use App\Http\Controllers\Admin\LoanController as AdminLoanController;
use App\Http\Controllers\User\LoanController as UserLoanController;
use App\Http\Controllers\ImpersonationController;

Route::get('/', function () {

    return redirect()->route('login');
    // return view('welcome');
});

// User routes
Route::middleware(['auth', 'usertype:user'])->name('user.')->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

    // Loan Apply (User)
    Route::get('/loan/apply', [UserLoanController::class, 'create'])->name('loan.apply');
    Route::post('/loan/apply/preview', [UserLoanController::class, 'preview'])->name('loan.apply.preview');
    Route::post('/loan/apply', [UserLoanController::class, 'store'])->name('loan.apply.store');
    // KYC Documents (session-backed)
    Route::get('/loan/documents', [UserLoanController::class, 'documentsForm'])->name('loan.documents.form');
    Route::post('/loan/documents', [UserLoanController::class, 'documentsStore'])->name('loan.documents.store');
    // Deposit step (session-backed)
    Route::get('/loan/deposit', [UserLoanController::class, 'depositForm'])->name('loan.deposit.form');
    Route::post('/loan/deposit', [UserLoanController::class, 'depositStore'])->name('loan.deposit.store');
});

// Admin routes
Route::middleware(['auth', 'usertype:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Site Settings
    Route::get('site-settings', [SiteSettingController::class, 'index'])->name('site-settings.index');
    Route::get('site-settings/{site_setting}/edit', [SiteSettingController::class, 'edit'])->name('site-settings.edit');
    Route::patch('site-settings/{site_setting}', [SiteSettingController::class, 'update'])->name('site-settings.update');

    // Users Management
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::get('users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::patch('users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::post('users/{user}/toggle', [AdminUserController::class, 'toggle'])->name('users.toggle');
    Route::post('users/{user}/impersonate', [AdminUserController::class, 'impersonate'])->name('users.impersonate');

    // Plans Management
    Route::get('plans', [AdminPlanController::class, 'index'])->name('plans.index');
    Route::get('plans/create', [AdminPlanController::class, 'create'])->name('plans.create');
    Route::post('plans', [AdminPlanController::class, 'store'])->name('plans.store');
    Route::get('plans/{plan}/edit', [AdminPlanController::class, 'edit'])->name('plans.edit');
    Route::patch('plans/{plan}', [AdminPlanController::class, 'update'])->name('plans.update');
    Route::delete('plans/{plan}', [AdminPlanController::class, 'destroy'])->name('plans.destroy');
    Route::post('plans/{plan}/toggle', [AdminPlanController::class, 'toggle'])->name('plans.toggle');

    // Limits (singleton) - only edit/update, no create
    Route::get('limit/edit', [AdminLimitController::class, 'edit'])->name('limit.edit');
    Route::patch('limit', [AdminLimitController::class, 'update'])->name('limit.update');

    // Gateways Management
    Route::get('gateways', [AdminGatewayController::class, 'index'])->name('gateways.index');
    Route::get('gateways/create', [AdminGatewayController::class, 'create'])->name('gateways.create');
    Route::post('gateways', [AdminGatewayController::class, 'store'])->name('gateways.store');
    Route::get('gateways/{gateway}/edit', [AdminGatewayController::class, 'edit'])->name('gateways.edit');
    Route::patch('gateways/{gateway}', [AdminGatewayController::class, 'update'])->name('gateways.update');
    Route::delete('gateways/{gateway}', [AdminGatewayController::class, 'destroy'])->name('gateways.destroy');
    Route::post('gateways/{gateway}/toggle', [AdminGatewayController::class, 'toggle'])->name('gateways.toggle');

    // Loans Management
    Route::get('loans', [AdminLoanController::class, 'index'])->name('loans.index');
    Route::get('loans/{loan}', [AdminLoanController::class, 'show'])->name('loans.show');
    Route::post('loans/{loan}/approve', [AdminLoanController::class, 'approve'])->name('loans.approve');
    Route::post('loans/{loan}/reject', [AdminLoanController::class, 'reject'])->name('loans.reject');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Stop impersonation
Route::post('/impersonate/stop', [ImpersonationController::class, 'stop'])->middleware('auth')->name('impersonate.stop');
