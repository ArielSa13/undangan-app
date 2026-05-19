<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Customer;
use App\Http\Controllers\InvitationViewController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PaymentWebhookController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', [LandingPageController::class, 'index'])->name('home');

// Payment Webhook (no CSRF)
Route::post('/payment/webhook', [PaymentWebhookController::class, 'handle'])
    ->name('payment.webhook')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [Auth\AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [Auth\AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [Auth\RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [Auth\RegisteredUserController::class, 'store']);
    Route::get('/forgot-password', [Auth\PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [Auth\PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [Auth\NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [Auth\NewPasswordController::class, 'store'])->name('password.store');
});

// Google Auth
Route::get('/auth/google/redirect', [Auth\GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [Auth\GoogleAuthController::class, 'callback']);

// OTP Verification (authenticated but not verified)
Route::middleware('auth')->group(function () {
    Route::get('/verify-otp', [Auth\OtpVerificationController::class, 'show'])->name('verification.otp');
    Route::post('/verify-otp', [Auth\OtpVerificationController::class, 'verify'])->name('verification.otp.verify');
    Route::post('/resend-otp', [Auth\OtpVerificationController::class, 'resend'])->name('verification.otp.resend');
    Route::post('/logout', [Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Customer Routes
Route::middleware(['auth', \App\Http\Middleware\EnsureEmailIsVerified::class])
    ->prefix('dashboard')
    ->name('customer.')
    ->group(function () {
        Route::get('/', [Customer\DashboardController::class, 'index'])->name('dashboard');

        // Invitations
        Route::resource('invitations', Customer\InvitationController::class);
        Route::post('invitations/{invitation}/publish', [Customer\InvitationController::class, 'publish'])->name('invitations.publish');
        Route::post('invitations/{invitation}/pause', [Customer\InvitationController::class, 'pause'])->name('invitations.pause');
        Route::post('invitations/{invitation}/duplicate', [Customer\InvitationController::class, 'duplicate'])->name('invitations.duplicate');

        // Guests
        Route::get('invitations/{invitation}/guests', [Customer\GuestController::class, 'index'])->name('guests.index');
        Route::post('invitations/{invitation}/guests', [Customer\GuestController::class, 'store'])->name('guests.store');
        Route::put('invitations/{invitation}/guests/{guest}', [Customer\GuestController::class, 'update'])->name('guests.update');
        Route::delete('invitations/{invitation}/guests/{guest}', [Customer\GuestController::class, 'destroy'])->name('guests.destroy');

        // Gallery
        Route::get('invitations/{invitation}/gallery', [Customer\GalleryController::class, 'index'])->name('gallery.index');
        Route::post('invitations/{invitation}/gallery', [Customer\GalleryController::class, 'store'])->name('gallery.store');
        Route::delete('invitations/{invitation}/gallery/{gallery}', [Customer\GalleryController::class, 'destroy'])->name('gallery.destroy');
        Route::post('invitations/{invitation}/gallery/reorder', [Customer\GalleryController::class, 'reorder'])->name('gallery.reorder');

        // Payments
        Route::get('packages', [Customer\PaymentController::class, 'packages'])->name('packages');
        Route::get('checkout/{package}', [Customer\PaymentController::class, 'checkout'])->name('checkout');
        Route::post('checkout/{package}', [Customer\PaymentController::class, 'process'])->name('checkout.process');
        Route::get('payments/{payment}/pay', [Customer\PaymentController::class, 'pay'])->name('payments.pay');
        Route::get('payments/history', [Customer\PaymentController::class, 'history'])->name('payments.history');
    });

// Admin Routes
Route::middleware(['auth', \App\Http\Middleware\EnsureEmailIsVerified::class, \App\Http\Middleware\AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // Users
        Route::get('users', [Admin\UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}', [Admin\UserController::class, 'show'])->name('users.show');
        Route::post('users/{user}/toggle-active', [Admin\UserController::class, 'toggleActive'])->name('users.toggle-active');

        // Invitations
        Route::get('invitations', [Admin\InvitationController::class, 'index'])->name('invitations.index');
        Route::get('invitations/{invitation}', [Admin\InvitationController::class, 'show'])->name('invitations.show');

        // Templates
        Route::get('templates', [Admin\TemplateController::class, 'index'])->name('templates.index');
        Route::get('templates/{template}/edit', [Admin\TemplateController::class, 'edit'])->name('templates.edit');
        Route::put('templates/{template}', [Admin\TemplateController::class, 'update'])->name('templates.update');
        Route::post('templates/{template}/toggle-active', [Admin\TemplateController::class, 'toggleActive'])->name('templates.toggle-active');

        // Payments
        Route::get('payments', [Admin\PaymentController::class, 'index'])->name('payments.index');
        Route::get('payments/{payment}', [Admin\PaymentController::class, 'show'])->name('payments.show');
    });

// Public Invitation View (MUST be last - catch-all slug)
Route::get('/{slug}', [InvitationViewController::class, 'show'])->name('invitation.show');
Route::post('/{slug}/rsvp', [InvitationViewController::class, 'submitRsvp'])->name('invitation.rsvp');
Route::post('/{slug}/guestbook', [InvitationViewController::class, 'submitGuestbook'])->name('invitation.guestbook');
