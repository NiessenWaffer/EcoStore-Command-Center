<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\GovernanceController;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\PassportVerificationController;
use App\Http\Controllers\ResaleController;
use App\Http\Controllers\FitProfileController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\Admin\HubInventoryController;
use App\Http\Controllers\Admin\SustainabilityMetricController;
use App\Http\Controllers\MissionController;

Route::get('/', function () {
    $featuredCollections = \App\Models\Category::whereNotNull('image_url')
        ->take(3)
        ->get();

    $latestProducts = \App\Models\Product::where('is_published', true)
        ->whereNotNull('image_url')
        ->latest()
        ->with('category')
        ->take(4)
        ->get();

    return view('home', compact('featuredCollections', 'latestProducts'));
})->name('home');

Route::get('/mission', [MissionController::class, 'index'])->name('mission');

Route::get('/shop', [ProductController::class, 'index'])->name('shop');
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product.show');

Route::get('/mission/{referral_code}', [ReferralController::class, 'missionPage'])->name('referral.mission');
Route::get('/passports', function () {
    return view('passports.index');
})->name('passports.index');

Route::get('/passport/{token}', [PassportController::class, 'show'])->name('passport.show');
Route::get('/passports/{id}/verify', [PassportVerificationController::class, 'verify'])->name('passports.verify');
Route::get('/claim/{token}', [\App\Http\Controllers\PassportTransferController::class, 'showClaim'])->name('passport.claim');

Route::get('/governance', [GovernanceController::class, 'index'])->name('governance.index');
Route::get('/governance/proposals/{id}', [GovernanceController::class, 'show'])->name('governance.show');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');

use App\Livewire\Dashboard\CommandCenter;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/{tab?}', CommandCenter::class)->name('dashboard');

    Route::get('/returns/deterrent', [ReturnController::class, 'showDeterrent'])->name('return.deterrent');
    Route::post('/returns/submit', [ReturnController::class, 'store'])->name('return.store');

    Route::get('/fit/wizard', [FitProfileController::class, 'showWizard'])->name('fit.wizard');
    Route::post('/fit/wizard', [FitProfileController::class, 'store'])->name('fit.store');

    Route::get('/resale', [ResaleController::class, 'index'])->name('resale.index');
    Route::get('/resale/submit', [ResaleController::class, 'create'])->name('resale.create');
    Route::post('/resale/submit', [ResaleController::class, 'store'])->name('resale.store');

    Route::get('/tracking/bike/{order}', function (\App\Models\Order $order) {
        return view('tracking.bike', compact('order'));
    })->name('tracking.bike');

    Route::get('/dashboard/certificate', function () {
        return view('dashboard.certificate');
    })->name('dashboard.certificate');

    Route::post('/api/geo/detect', [\App\Http\Controllers\GeoRoutingController::class, 'detect'])->name('api.geo.detect');
    Route::get('/api/geo/transit-impact', [\App\Http\Controllers\GeoRoutingController::class, 'calculateImpact'])->name('api.geo.impact');
});

Route::get('/certificate/verify/{signature}', function ($signature) {
    return "Verification Page for Signature: " . $signature;
})->name('certificate.verify');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/metrics', [SustainabilityMetricController::class, 'index'])->name('admin.metrics');

    Route::get('/products', [ProductAdminController::class, 'index'])->name('admin.products');
    Route::get('/governance', [GovernanceController::class, 'adminIndex'])->name('admin.governance');
    Route::get('/corrections', [PassportVerificationController::class, 'correctionQueue'])->name('admin.corrections.index');
    Route::get('/hubs/map', function() { return view('admin.hub.map'); })->name('admin.hubs.map');
    Route::get('/products/create', [ProductAdminController::class, 'create'])->name('admin.products.create');
    Route::post('/passports/{id}/events', [PassportVerificationController::class, 'storeEvent'])->name('admin.passports.events');

    Route::get('/hub', [HubInventoryController::class, 'adminIndex'])->name('admin.hub.index');
    Route::get('/hub/{hub}/manage', [HubInventoryController::class, 'index'])->name('admin.hub.manage');
    Route::post('/hub/verify/{tradeIn}', [HubInventoryController::class, 'verifyReturn'])->name('admin.hub.verify');
});
