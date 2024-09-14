<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ProblemReportController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\UserNotificationController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\AnalyticsController;

/**
 * Home Route
 */
Route::get('/', [AuthController::class, 'home'])->name('home');

/**
 * Guest Routes (Login, Registration, Password Reset)
 */
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/check', fn () => view('auth.passwords.check'))->name('check');
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

/**
 * Authenticated User Routes
 */
Route::middleware('auth')->group(function () {
    // User logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Cart Routes
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Wishlist Routes
    Route::post('/wishlist/add', [WishlistController::class, 'store'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'destroy'])->name('wishlist.remove');
    Route::post('/wishlist/toggle/{productId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Product Review Routes
    Route::post('/reviews', [ProductReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{productId}', [ProductReviewController::class, 'show'])->name('reviews.show');

    // Notifications Update
    Route::post('/notifications/update', [UserNotificationController::class, 'update'])->name('notifications.update');
});

/**
 * Product Routes
 */
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

/**
 * Contact and Help Routes
 */
Route::get('/help', [ContactController::class, 'index'])->name('help');
Route::post('/help/send', [ContactController::class, 'store'])->name('contact.send');

/**
 * Coupon Route
 */
Route::post('/apply-coupon', [CouponController::class, 'apply'])->name('apply.coupon');

/**
 * User Settings Routes
 */
Route::get('/setting', [SettingController::class, 'index'])->name('setting');
Route::post('/setting/edit', [SettingController::class, 'updatePassword'])->name('setting.updatePassword');
Route::post('/setting', [SettingController::class, 'update'])->name('profile.update');
Route::post('/setting/update-image', [SettingController::class, 'updateImage'])->name('profile.updateImage');
Route::delete('/setting/deleteImage', [SettingController::class, 'deleteImage'])->name('profile.deleteImage');

/**
 * Problem Report Route
 */
Route::post('/report-problem', [ProblemReportController::class, 'store'])->name('report.problem.store');

/**
 * Social Authentication Routes
 */
Route::prefix('auth')->group(function () {
    Route::get('google', [SocialAuthController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
    Route::get('facebook', [SocialAuthController::class, 'redirectToFacebook'])->name('facebook.login');
    Route::get('facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);
    Route::get('twitter', [SocialAuthController::class, 'redirectToTwitter']);
    Route::get('twitter/callback', [SocialAuthController::class, 'handleTwitterCallback']);
});

/**
 * Checkout Routes
 */
Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'showCheckout'])->name('checkout.show');
    Route::post('/', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/cancel/{order}', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
});

/**
 * Admin Routes (Authenticated Admins Only)
 */
Route::middleware('auth:admin')->prefix('admin')->group(function () {
    Route::get('dashboard', [AuthAdminController::class, 'showDashboard'])->name('admin.dashboard');

    // Product Management (Admin)
    Route::get('products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('products/add', [ProductController::class, 'add'])->name('admin.products.add');
    Route::post('products/promostore', [ProductController::class, 'promostore'])->name('promotions.store');
    Route::get('products/edit/{id}', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::get('products/search', [ProductController::class, 'search'])->name('admin.products.search');
    Route::delete('products/destroy/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    // Admin Settings
    Route::get('settings', [SettingsController::class, 'showSetting'])->name('admin.settings');
    Route::post('settings/update-password', [SettingsController::class, 'updatePassword'])->name('admin.settings.updatePassword');
    Route::post('settings/update-email', [SettingsController::class, 'updateEmail'])->name('admin.settings.updateEmail');
    Route::post('settings/update-seller-details', [SettingsController::class, 'updateSellerDetails'])->name('admin.settings.updateSellerDetails');
    Route::post('settings/update-bank-details', [SettingsController::class, 'updateBankDetails'])->name('admin.settings.updateBankDetails');

    // Analytics
    Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics');

    // Admin Logout
    Route::post('logout', [AuthAdminController::class, 'logout'])->name('admin.logout');
});

/**
 * Admin Authentication Routes for Guests
 */
Route::middleware('guest:admin')->prefix('admin')->group(function () {
    Route::get('login', [AuthAdminController::class, 'showLogin'])->name('admin.showlogin');
    Route::post('loginfunc', [AuthAdminController::class, 'login'])->name('admin.login');
    Route::get('register', [AuthAdminController::class, 'showRegistrationForm'])->name('admin.showreg');
    Route::post('register/func', [AuthAdminController::class, 'register'])->name('admin.register');
});
