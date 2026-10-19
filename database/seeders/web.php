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
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DomainController as AdminDomainController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\HostingController as AdminHostingController;
use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\PaymentSettingController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\ServerController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SupportTicketController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FreeEmailRequestController;
use App\Http\Controllers\Admin\BusinessEmailController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\StaticPageController;
use App\Http\Controllers\Frontend\DomainController as FrontendDomainController;
use App\Http\Controllers\Frontend\HostingController as FrontendHostingController;
use App\Http\Controllers\Frontend\ServerController as FrontendServerController;
use App\Http\Controllers\Frontend\ServiceController as FrontendServiceController;
use App\Http\Controllers\Frontend\CommunityController as FrontendCommunityController;
use App\Http\Controllers\Frontend\WhyChooseUsController as FrontendWhyChooseUsController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\Customer\DashboardController;
use App\Http\Controllers\Frontend\Customer\BillingController;
use App\Http\Controllers\Frontend\Customer\DomainController;
use App\Http\Controllers\Frontend\Customer\EmailController;
use App\Http\Controllers\Frontend\Customer\HostingController;
use App\Http\Controllers\Frontend\Customer\ProfileController;
use App\Http\Controllers\Frontend\Customer\ReportIssueController;
use App\Http\Controllers\Frontend\Customer\CustomerSupportTicketController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\HostingOrderController;
use App\Http\Controllers\Frontend\EmailOrderController;

use Illuminate\Support\Facades\Route;
use App\Services\OpenProviderService;

/*
|--------------------------------------------------------------------------
| Frontend Routes (Public)
|--------------------------------------------------------------------------
*/




// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Redirect authenticated users from generic /dashboard to role-based dashboard
Route::get('/dashboard', function () {
    if (auth()->check()) {
        if (auth()->user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('customer.dashboard');
    }
    return redirect()->route('login');
})->middleware(['auth'])->name('dashboard');

// Logout
Route::post('/logout', [LogoutController::class, 'store'])->middleware(['auth'])->name('logout');


/*
|--------------------------------------------------------------------------
| Domain
|--------------------------------------------------------------------------
*/

Route::get('/domain-name-registration', [FrontendDomainController::class, 'domainNameRegistration'])->name('domain.name.registration');
Route::post('/domain-check', [FrontendDomainController::class, 'checkDomain'])->name('domain.check');
Route::post('/domain-suggestions', [FrontendDomainController::class, 'suggestions'])->name('domain.suggestions');
Route::post('/domain-order', [FrontendDomainController::class, 'domainOrder'])->name('domain.order.store');
Route::get('/domain-order/process', [FrontendDomainController::class, 'processPendingOrder'])->name('domain.order.process')->middleware('auth');

Route::post('/bulk-domain-order', [FrontendDomainController::class, 'bulkDomainOrder'])->name('bulk.domain.order.store');
Route::get('/bulk-domain-order/process', [FrontendDomainController::class, 'processPendingBulkOrder'])->name('bulk.domain.order.process')->middleware('auth');

Route::get('/cart/domain-checkout/{id}', [FrontendDomainController::class, 'checkout'])->name('domain.checkout');


Route::get('/domain-transfer', [FrontendDomainController::class, 'domainTransfer'])->name('domain.transfer');
Route::post('/domain-transfer', [FrontendDomainController::class, 'checkDomainTransfer'])->name('domain.transfer.check');



Route::get('/maintenance', function () {
    return view('frontend.maintenance');
})->name('maintenance');

Route::get('/create-storage-link', function () {
    $target = storage_path('app/public');
    $shortcut = public_path('storage');
    if (!file_exists($shortcut)) {
        try {
            app('files')->link($target, $shortcut);
            return '<h2 style="color:green;">Storage symlink created successfully!</h2>';
        } catch (\Exception $e) {
            return '<h2 style="color:red;">Error creating symlink: ' . $e->getMessage() . '</h2>';
        }
    }
    return '<h2 style="color:blue;">Storage symlink already exists!</h2>';
});

Route::get('/bulk-domain-transfer', [FrontendDomainController::class, 'bulkDomainTransfer'])->name('bulk.domain.transfer');
Route::post('/bulk-domain-transfer-check', [FrontendDomainController::class, 'checkBulkDomainTransfer'])->name('bulk.domain.transfer.check');


Route::get('/whois-domain-lookup', [FrontendDomainController::class, 'whoisDomainLookup'])->name('whois.domain.lookup');
Route::post('/whois-domain-lookup', [FrontendDomainController::class, 'whoisSearch'])->name('whois.domain.search');

/*
|--------------------------------------------------------------------------
| Hosting
|--------------------------------------------------------------------------
*/

Route::get('/shared-web-hosting', [FrontendHostingController::class, 'sharedWebHosting'])->name('shared.web.hosting');

Route::get('/cpanel-hosting', [FrontendHostingController::class, 'cpanelHosting'])->name('cpanel.hosting');

Route::get('/crm-hosting', [FrontendHostingController::class, 'crmHosting'])->name('crm.hosting');

Route::get('/plesk-hosting', [FrontendHostingController::class, 'pleskHosting'])->name('plesk.hosting');

Route::get('/cloud-hosting', [FrontendHostingController::class, 'cloudHosting'])->name('cloud.hosting');

Route::get('/wordpress-hosting', [FrontendHostingController::class, 'wordpressHosting'])->name('wordpress.hosting');

Route::get('/woocommerce-hosting', [FrontendHostingController::class, 'woocommerceHosting'])->name('woocommerce.hosting');

// Dynamic hosting routes
Route::get('/hosting', [FrontendHostingController::class, 'list'])->name('hosting.list');
Route::get('/hosting/{slug}', [FrontendHostingController::class, 'show'])->name('hosting.show');

// Hosting plan order (auth required)
Route::post('/hosting-order', [HostingOrderController::class, 'createOrder'])->name('hosting.order.store')->middleware('auth');
Route::get('/cart/hosting-checkout/{id}', [HostingOrderController::class, 'checkout'])->name('hosting.checkout')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Server
|--------------------------------------------------------------------------
*/

Route::get('/vps-server', [FrontendServerController::class, 'vpsServer'])->name('vps.server');

Route::get('/dedicated-server', [FrontendServerController::class, 'dedicatedServer'])->name('dedicated.server');

// Dynamic server route (must be after named static routes)
Route::get('/server/{slug}', [FrontendServerController::class, 'show'])->name('server.show');


/*
|--------------------------------------------------------------------------
| Services
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Frontend\Customer\EmailController as FrontendCustomerEmailController;

Route::get('/business-mail', [FrontendServiceController::class, 'businessMail'])->name('business.mail');
Route::get('/google-gmail-suite', [FrontendCustomerEmailController::class, 'suit'])->name('google.gmail.suite');
Route::get('/microsoft-office-365', [FrontendCustomerEmailController::class, 'msOffice'])->name('microsoft.office.365');
Route::get('/professional-business-mail', [FrontendCustomerEmailController::class, 'pbMail'])->name('professional.business.mail');

Route::get('/server-management', [FrontendServiceController::class, 'serverManagement'])->name('server.management');

Route::get('/dedicated-support', [FrontendServiceController::class, 'dedicatedSupport'])->name('dedicated.support');

Route::get('/cyber-security', [FrontendServiceController::class, 'cyberSecurity'])->name('cyber.security');

Route::get('/dedicated-services-server', [FrontendServiceController::class, 'dedicatedServicesServer'])->name('dedicated.services.server');

Route::get('/website-migration', [FrontendServiceController::class, 'websiteMigration'])->name('website.migration');

Route::get('/privacy-policy', [StaticPageController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/terms-of-use', [StaticPageController::class, 'termsOfUse'])->name('terms.of.use');
Route::get('/payment-method', [StaticPageController::class, 'paymentMethod'])->name('payment.method');


/*
|--------------------------------------------------------------------------
| Community
|--------------------------------------------------------------------------
*/

Route::get('/blog', [FrontendCommunityController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [FrontendCommunityController::class, 'blogDetails'])->name('blog.show');

Route::get('/faqs', [FrontendCommunityController::class, 'faqs'])->name('faqs');

Route::get('/contact', [FrontendCommunityController::class, 'contact'])->name('contact');
Route::post('/contact/submit', [FrontendCommunityController::class, 'contactSubmit'])->name('contact.submit');


/*
|--------------------------------------------------------------------------
| Why Choose Us
|--------------------------------------------------------------------------
*/

Route::get('/about-us', [FrontendWhyChooseUsController::class, 'aboutUs'])->name('about.us');

Route::get('/trust-security', [FrontendWhyChooseUsController::class, 'trustSecurity'])->name('trust.security');

Route::get('/customer-support', [FrontendWhyChooseUsController::class, 'customerSupport'])->name('customer.support');

Route::get('/ten-years-of-experience', [FrontendWhyChooseUsController::class, 'tenYearsOfExperience'])->name('ten.years.of.experience');

Route::get('/testimonials', [FrontendWhyChooseUsController::class, 'testimonials'])->name('testimonials');




Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout')->middleware('auth');
Route::get('/cart/remove-domain/{id}', [CartController::class, 'removeDomain'])->name('cart.remove.domain')->middleware('auth');
Route::get('/cart/remove-hosting/{id}', [CartController::class, 'removeHosting'])->name('cart.remove.hosting')->middleware('auth');
Route::get('/cart/remove-email/{id}', [CartController::class, 'removeEmail'])->name('cart.remove.email')->middleware('auth');
Route::get('/cart/add-renewal/{type}/{id}', [CartController::class, 'addRenewal'])->name('cart.add.renewal')->middleware('auth');
Route::post('/cart/update-domain-period', [CartController::class, 'updateDomainPeriod'])->name('cart.update.domain.period')->middleware('auth');
Route::post('/cart/update-hosting-period', [CartController::class, 'updateHostingPeriod'])->name('cart.update.hosting.period')->middleware('auth');

Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.apply.coupon');
Route::post('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.remove.coupon');
Route::post('/cart/update-billing-address', [CartController::class, 'updateBillingAddress'])->name('cart.update.billing.address')->middleware('auth');

// World Location API (Accessible across frontend and cart)
Route::get('/api/countries', [\App\Http\Controllers\Admin\LocationController::class, 'countries'])->name('api.countries');
Route::get('/api/states/{country}', [\App\Http\Controllers\Admin\LocationController::class, 'states'])->name('api.states');
Route::get('/api/cities/{state}', [\App\Http\Controllers\Admin\LocationController::class, 'cities'])->name('api.cities');





/*
|--------------------------------------------------------------------------
| Frontend Authentication
|--------------------------------------------------------------------------
*/

Route::middleware(['guest'])->group(function () {

    // Google Login
    Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

    // Login
    Route::get('/login', [\App\Http\Controllers\Frontend\Auth\LoginController::class, 'index'])->name('login');
    Route::post('/login-store', [\App\Http\Controllers\Frontend\Auth\LoginController::class, 'store'])->name('login.store');

    // Register
    Route::get('/register', [\App\Http\Controllers\Frontend\Auth\RegisterController::class, 'index'])->name('register');
    Route::post('/register-store', [\App\Http\Controllers\Frontend\Auth\RegisterController::class, 'store'])->name('register.store');

    // Admin Login
    Route::get('/admin/login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'index'])->name('admin.login');
    Route::post('/admin/login-store', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'store'])->name('admin.login.store');

    // Admin Register
    Route::get('/admin/register', [\App\Http\Controllers\Admin\Auth\RegisterController::class, 'index'])->name('admin.register');
    Route::post('/admin/register-store', [\App\Http\Controllers\Admin\Auth\RegisterController::class, 'store'])->name('admin.register.store');

    // OTP Verification (Frontend)
    Route::get('/verify-otp/{id}', [OtpVerificationController::class, 'index'])->name('verify.otp');
    Route::post('/verify-otp/{id}', [OtpVerificationController::class, 'verify'])->name('verify.otp.check');
    Route::post('/verify-otp/{id}/resend', [OtpVerificationController::class, 'resend'])->name('verify.otp.resend');

    // OTP Verification (Admin)
    Route::get('/admin/verify-otp/{id}', [OtpVerificationController::class, 'index'])->name('admin.verify.otp');
    Route::post('/admin/verify-otp/{id}', [OtpVerificationController::class, 'verify'])->name('admin.verify.otp.check');
    Route::post('/admin/verify-otp/{id}/resend', [OtpVerificationController::class, 'resend'])->name('admin.verify.otp.resend');

    // Forgot Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot.password');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('forgot.password.store');
    Route::get('/forgot-password/verify/{id}', [ForgotPasswordController::class, 'verifyForm'])->name('forgot.password.verify');
    Route::post('/forgot-password/verify/{id}', [ForgotPasswordController::class, 'verifyOtp'])->name('forgot.password.verify.check');
    Route::get('/forgot-password/reset', [ForgotPasswordController::class, 'resetForm'])->name('forgot.password.reset.form');
    Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('forgot.password.reset.submit');

    // Reset Password
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'index'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('reset.password.store');
});


/*
|--------------------------------------------------------------------------
| Customer Panel
|--------------------------------------------------------------------------
*/

Route::prefix('customer')->name('customer.')->middleware(['auth', 'customer'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Hosting
    Route::get('/hosting', [HostingController::class, 'index'])->name('hosting');

    // Domains
    Route::get('/domains', [DomainController::class, 'index'])->name('domains');

    // Emails
    Route::get('/emails', [EmailController::class, 'index'])->name('emails');
    Route::get('/plans', [EmailController::class, 'plans'])->name('emails.plans');
    Route::get('/request-free', [EmailController::class, 'requestFree'])->name('emails.request.free');
    Route::post('/request-free', [EmailController::class, 'submitFreeRequest'])->name('emails.request.free.store');

    Route::post('/email-order', [EmailOrderController::class, 'createOrder'])->name('email.order.store');
    Route::get('/cart/email-checkout/{id}', [EmailOrderController::class, 'checkout'])->name('email.checkout');

    Route::get('/google-gmail-suit', [EmailController::class, 'suit'])->name('suit');
    Route::get('/ms-office', [EmailController::class, 'msOffice'])->name('msoffice');
    Route::get('/professional-business-mail', [EmailController::class, 'pbMail'])->name('pbmail');


    // Billing
    Route::get('/billing', [BillingController::class, 'index'])->name('billing');
    Route::get('/billing/export-csv', [BillingController::class, 'exportCsv'])->name('billing.export');
    Route::get('/invoices/{invoice}/download', [BillingController::class, 'download'])->name('invoices.download');
    Route::get('/invoices/{invoice}/download-csv', [BillingController::class, 'downloadCsv'])->name('invoices.download.csv');

    // My Account
    Route::resource('my-account', ProfileController::class);

    // Change Password
    Route::get('/change-password', [ChangePasswordController::class, 'index'])->name('change.password');
    Route::post('/change-password', [ChangePasswordController::class, 'store'])->name('change.password.store');
    Route::get('/change-password/verify', [ChangePasswordController::class, 'verifyForm'])->name('change.password.verify');
    Route::post('/change-password/verify', [ChangePasswordController::class, 'verifyOtp'])->name('change.password.verify.check');

    // Report Issue

    Route::get('/report-issue', [ReportIssueController::class, 'index'])->name('report.issue');
    Route::post('/report-issue', [ReportIssueController::class, 'store'])->name('report.issue.store');

    // My Ticket
    Route::get('/tickets', [CustomerSupportTicketController::class, 'index'])->name('tickets');
    Route::get('/tickets/{ticket}', [CustomerSupportTicketController::class, 'show'])->name('tickets.show');
});


/*
|--------------------------------------------------------------------------
| Payment
|--------------------------------------------------------------------------
*/

Route::prefix('payment')->name('payment.')->group(function () {

    Route::get('/', [PaymentController::class, 'index'])->name('index');

    Route::post('/create-order', [PaymentController::class, 'createOrder'])->name('create-order');

    Route::post('/verify', [PaymentController::class, 'verifyPayment'])->name('verify');

    Route::get('/success', [PaymentController::class, 'success'])->name('success');

    Route::get('/failed', [PaymentController::class, 'failed'])->name('failed');
});

/*
|--------------------------------------------------------------------------
| Admin Panel
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/change-password', [ChangePasswordController::class, 'index'])->name('change.password');
    Route::post('/change-password', [ChangePasswordController::class, 'store'])->name('change.password.store');
    Route::get('/change-password/verify', [ChangePasswordController::class, 'verifyForm'])->name('change.password.verify');
    Route::post('/change-password/verify', [ChangePasswordController::class, 'verifyOtp'])->name('change.password.verify.check');

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('profile', AdminProfileController::class);

    // World Location API
    Route::get('countries', [LocationController::class, 'countries'])->name('countries');
    Route::get('states/{country}', [LocationController::class, 'states'])->name('states');
    Route::get('cities/{state}', [LocationController::class, 'cities'])->name('cities');

    // Users
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');
    Route::resource('users', UserController::class);

    // Invoice
    Route::get('invoices', [AdminInvoiceController::class, 'index'])->name('invoices.index');
    Route::get('invoices/export', [AdminInvoiceController::class, 'export'])->name('invoices.export');
    Route::get('invoices/{invoice}', [AdminInvoiceController::class, 'show'])->name('invoices.show');
    Route::get('invoices/{invoice}/download', [AdminInvoiceController::class, 'download'])->name('invoices.download');
    Route::post('invoices/{invoice}/send-renewal-reminder', [AdminInvoiceController::class, 'sendRenewalReminder'])->name('invoices.send-renewal-reminder');

    // Hosting
    Route::resource('hostings', AdminHostingController::class);

    // Plan
    Route::get('plans/hosting/{hosting}', [PlanController::class, 'byHosting'])->name('plans.byHosting');
    Route::get('plans/server/{server}', [PlanController::class, 'byServer'])->name('plans.byServer');
    Route::resource('plans', PlanController::class);

    // FAQ
    Route::get('faqs/hosting/{hosting}', [FAQController::class, 'byHosting'])->name('faqs.byHosting');
    Route::get('faqs/server/{server}', [FAQController::class, 'byServer'])->name('faqs.byServer');
    Route::resource('faqs', FAQController::class);

    // Domain
    Route::resource('domains', AdminDomainController::class);

    // Server

    Route::resource('servers', ServerController::class);

    // Blog
    Route::resource('blogs', BlogController::class);

    // Testimonial
    Route::resource('testimonials', TestimonialController::class);

    // Contact Inquiries
    Route::get('/contacts', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contacts');
    Route::delete('/contacts/{id}', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contacts.destroy');
    Route::post('/contacts/{id}/reply', [\App\Http\Controllers\Admin\ContactController::class, 'reply'])->name('contacts.reply');

    // Notification
    Route::resource('notifications', AdminNotificationController::class);

    // Offer
    Route::resource('offers', OfferController::class);

    // Payment
    Route::resource('payment-settings', PaymentSettingController::class);

    // Transaction
    Route::resource('transactions', TransactionController::class);

    // Support Ticket (report an issue)
    Route::resource('support-tickets', SupportTicketController::class)->only(['index', 'show', 'update']);
    Route::post('support-tickets/{supportTicket}/reply', [SupportTicketController::class, 'reply'])->name('support-tickets.reply');

    // Free Email Requests
    Route::get('free-email-requests', [FreeEmailRequestController::class, 'index'])->name('free-email-requests.index');
    Route::get('free-email-requests/{freeEmailRequest}', [FreeEmailRequestController::class, 'show'])->name('free-email-requests.show');
    Route::post('free-email-requests/{freeEmailRequest}/approve', [FreeEmailRequestController::class, 'approve'])->name('free-email-requests.approve');
    Route::post('free-email-requests/{freeEmailRequest}/reject', [FreeEmailRequestController::class, 'reject'])->name('free-email-requests.reject');
    Route::delete('free-email-requests/{freeEmailRequest}', [FreeEmailRequestController::class, 'destroy'])->name('free-email-requests.destroy');

    // Business Emails
    Route::resource('business-emails', BusinessEmailController::class);

    // Coupons
    Route::resource('coupons', CouponController::class);

    // Settings
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
