<?php

use App\Http\Controllers\Admin\Auth\ChangePasswordController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\GoogleController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\Auth\OtpVerificationController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DomainController;
use App\Http\Controllers\Admin\HostingCategoryController;
use App\Http\Controllers\Admin\HostingController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\PaymentSettingController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ServerCategoryController;
use App\Http\Controllers\Admin\ServerController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;


use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Frontend Routes (Public)
|--------------------------------------------------------------------------
*/

Route::middleware(['guest'])->group(function () {

    // Login
    Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login-store', [LoginController::class, 'store'])->name('login.store');

    // register
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register-store', [RegisterController::class, 'store'])->name('register.store');

    // OTP Verification
    Route::get('/verify-otp/{id}', [OtpVerificationController::class, 'index'])->name('verify.otp');
    Route::post('/verify-otp/{id}', [OtpVerificationController::class, 'verify'])->name('verify.otp.check');

    // Forgot Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot.password');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('forgot.password.store');

    // Reset Password
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'index'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('reset.password.store');
});



/*
|--------------------------------------------------------------------------
| Admin Panel
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/change-password', [ChangePasswordController::class, 'index'])->name('change.password');
    Route::post('/change-password', [ChangePasswordController::class, 'store'])->name('change.password.store');

    Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('profile', ProfileController::class);

    // World Location API
    Route::get('countries', [LocationController::class, 'countries'])->name('countries');
    Route::get('states/{country}', [LocationController::class, 'states'])->name('states');
    Route::get('cities/{state}', [LocationController::class, 'cities'])->name('cities');

    // Users
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');
    Route::resource('users', UserController::class);

    // Invoice
    Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('invoices/export', [InvoiceController::class, 'export'])->name('invoices.export');
    Route::get('invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');

    // Hosting
    Route::resource('hosting-categories', HostingCategoryController::class);
    Route::resource('hostings', HostingController::class);
    
    // Domain
    Route::resource('domains', DomainController::class);

    // Server
    Route::resource('server-categories', ServerCategoryController::class);
    Route::resource('servers', ServerController::class);

    // Blog
    Route::resource('blogs', BlogController::class);

    // Testimonial
    Route::resource('testimonials', TestimonialController::class);

    // Notification
    Route::resource('notifications', NotificationController::class);

    // Offer
    Route::resource('offers', OfferController::class);

    // Payment/Transaction
    Route::resource('payment-settings', PaymentSettingController::class);
    Route::resource('transactions', TransactionController::class);

    Route::prefix('settings')->name('settings.')->controller(SettingController::class)->group(function () {

        Route::get('/general', 'general')->name('general');
        Route::put('/general', 'updateGeneral')->name('general.update');

        Route::get('/company', 'company')->name('company');
        Route::put('/company', 'updateCompany')->name('company.update');

        Route::get('/contact', 'contact')->name('contact');
        Route::put('/contact', 'updateContact')->name('contact.update');

        Route::get('/social', 'social')->name('social');
        Route::put('/social', 'updateSocial')->name('social.update');

        Route::get('/payment', 'payment')->name('payment');
        Route::put('/payment', 'updatePayment')->name('payment.update');

        Route::get('/seo', 'seo')->name('seo');
        Route::put('/seo', 'updateSeo')->name('seo.update');

        Route::get('/api', 'api')->name('api');
        Route::put('/api', 'updateApi')->name('api.update');
    });
});
