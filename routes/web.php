<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CustomerPortalController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\GoogleController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\HotelAdminController;
use App\Http\Controllers\Admin\CabAdminController;
use App\Http\Controllers\Admin\ShopAdminController;
use App\Http\Controllers\Admin\CustomerAdminController;
use App\Http\Controllers\Admin\SettingAdminController;
use App\Http\Controllers\Admin\CouponAdminController;
use App\Http\Controllers\Admin\TicketAdminController;
use App\Http\Controllers\Admin\ReviewAdminController;
use App\Http\Controllers\Admin\FeedbackAdminController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EmailServiceController;
use App\Http\Controllers\Admin\FreeEmailRequestController;
use App\Http\Controllers\Admin\BusinessEmailController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\PaymentSettingController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\SupportTicketController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\Auth\ChangePasswordController;

/*
|--------------------------------------------------------------------------
| World Location API Routes (Hostlok Synced MySQL DB)
|--------------------------------------------------------------------------
*/
Route::get('/api/location/countries', [LocationController::class, 'getCountries'])->name('api.countries');
Route::get('/api/location/states/{country}', [LocationController::class, 'getStates'])->name('api.states');
Route::get('/api/location/cities/{state}', [LocationController::class, 'getCities'])->name('api.cities');
Route::get('/debug-ping', function () {
    $dbError = null;
    $dbConnected = false;
    try {
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        $dbConnected = true;
    } catch (\Throwable $e) {
        $dbError = $e->getMessage();
    }

    $user4 = null;
    $cabsCount = 0;
    try {
        if (\Illuminate\Support\Facades\Schema::hasTable('users')) {
            $user4 = \Illuminate\Support\Facades\DB::table('users')->where('id', 4)->first();
        }
        if (\Illuminate\Support\Facades\Schema::hasTable('cab_bookings')) {
            $cabsCount = \Illuminate\Support\Facades\DB::table('cab_bookings')->count();
        }
    } catch (\Throwable $e) {}

    return response()->json([
        'status' => 'ok',
        'build' => 'v5_sqlite_fallback',
        'db_connected' => $dbConnected,
        'db_error' => $dbError,
        'default_connection' => config('database.default'),
        'user4' => $user4,
        'cabs_count' => $cabsCount,
        'sqlite_file_exists' => file_exists(database_path('database.sqlite')),
    ]);
});
Route::get('/sitemap.xml', function () {
    $path = public_path('sitemap.xml');
    if (file_exists($path)) {
        return response()->file($path, ['Content-Type' => 'application/xml']);
    }
    abort(404);
})->name('sitemap');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Hostlok Full Auth System)
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/admin/login', [LoginController::class, 'index'])->name('admin.login');
Route::post('/login', [LoginController::class, 'store'])->name('admin.login.store');

Route::get('/register', [RegisterController::class, 'index'])->name('admin.register');
Route::post('/register', [RegisterController::class, 'store'])->name('admin.register.store');

Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot.password');
Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('forgot.password.send');
Route::post('/forgot-password/store', [ForgotPasswordController::class, 'store'])->name('forgot.password.store');

Route::get('/verify-otp/{id?}', [ForgotPasswordController::class, 'verifyForm'])->name('forgot.password.verify');
Route::post('/verify-otp/{id?}', [ForgotPasswordController::class, 'verifyOtp'])->name('verify.otp.store');
Route::post('/verify-otp-check/{id?}', [ForgotPasswordController::class, 'verifyOtp'])->name('verify.otp.check');
Route::post('/verify-otp-resend/{id?}', [ForgotPasswordController::class, 'verifyForm'])->name('verify.otp.resend');
Route::post('/admin-verify-otp-check/{id?}', [ForgotPasswordController::class, 'verifyOtp'])->name('admin.verify.otp.check');
Route::post('/admin-verify-otp-resend/{id?}', [ForgotPasswordController::class, 'verifyForm'])->name('admin.verify.otp.resend');
Route::post('/forgot-password-verify-check/{id?}', [ForgotPasswordController::class, 'verifyOtp'])->name('forgot.password.verify.check');

Route::get('/reset-password', [ForgotPasswordController::class, 'resetForm'])->name('forgot.password.reset.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset.password.update');
Route::post('/reset-password/submit', [ForgotPasswordController::class, 'resetPassword'])->name('forgot.password.reset.submit');
Route::post('/reset-password/store', [ForgotPasswordController::class, 'resetPassword'])->name('reset.password.store');

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Frontend Home & Public Pages
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/home', [HomeController::class, 'index']);

// About Menu
Route::get('/about-us', [HomeController::class, 'about'])->name('about');
Route::get('/history', [HomeController::class, 'history'])->name('history');
Route::get('/sufism', [HomeController::class, 'sufism'])->name('sufism');
Route::get('/hajiwarisalishah', [HomeController::class, 'hajiwarisalishah'])->name('hajiwarisalishah');
Route::get('/mazar', [HomeController::class, 'mazar'])->name('mazar');
Route::get('/ziyarat', [HomeController::class, 'mazar'])->name('ziyarat');
Route::get('/gallery', [HomeController::class, 'gellary'])->name('gallery');
Route::get('/qurbanalishah', [HomeController::class, 'qurbanalishah'])->name('qurbanalishah');
Route::get('/badelamazar', [HomeController::class, 'badelamazar'])->name('badelamazar');
Route::get('/shahwilayatshah', [HomeController::class, 'shahwilayatshah'])->name('shahwilayatshah');
Route::get('/shahwilayatmazar', [HomeController::class, 'shahwilayatmazar'])->name('shahwilayatmazar');
Route::get('/raheemshah', [HomeController::class, 'raheemshah'])->name('raheemshah');
Route::get('/raheemshahmazar', [HomeController::class, 'raheemshahmazar'])->name('raheemshahmazar');
Route::get('/faizushah', [HomeController::class, 'faizushah'])->name('faizushah');
Route::get('/faizushahmazar', [HomeController::class, 'faizushahmazar'])->name('faizushahmazar');
Route::get('/mosquedargah', [HomeController::class, 'mosquedargah'])->name('mosquedargah');
Route::get('/wazukhana', [HomeController::class, 'wazukhana'])->name('wazukhana');
Route::get('/langarkhana', [HomeController::class, 'langarkhana'])->name('langarkhana');
Route::get('/samakhana', [HomeController::class, 'samakhana'])->name('samakhana');
Route::get('/qawwaliplace', [HomeController::class, 'qawwaliplace'])->name('qawwaliplace');
Route::get('/trustoffice', [HomeController::class, 'trustoffice'])->name('trustoffice');
Route::get('/mela', [HomeController::class, 'mela'])->name('mela');
Route::get('/numaisground', [HomeController::class, 'numaisground'])->name('numaisground');
Route::get('/auditorium', [HomeController::class, 'auditorium'])->name('auditorium');
Route::get('/eidgaah', [HomeController::class, 'eidgaah'])->name('eidgaah');
Route::get('/culture', [HomeController::class, 'artandculture'])->name('artandculture');
Route::get('/artandcraft', [HomeController::class, 'artandcraft'])->name('artandcraft');
Route::get('/madarsalist', [HomeController::class, 'madarsalist'])->name('madarsalist');
Route::get('/education', [HomeController::class, 'collegeslist'])->name('collegeslist');
Route::get('/hospitals', [HomeController::class, 'hospitals'])->name('hospitals');
Route::get('/docters', [HomeController::class, 'docters'])->name('docters');
Route::get('/banks', [HomeController::class, 'bank'])->name('bank');
Route::get('/thana', [HomeController::class, 'thana'])->name('thana');
Route::get('/postoffice', [HomeController::class, 'postoffice'])->name('postoffice');
Route::get('/townarea', [HomeController::class, 'townarea'])->name('townarea');
Route::get('/safayiheroes', [HomeController::class, 'safayiheroes'])->name('safayiheroes');

// Aulia-Allah & AhleBayt Pages
Route::get('/abdulqadirgilani', [HomeController::class, 'baghdad'])->name('abdulqadirgilani');
Route::get('/muinuddinchisti', [HomeController::class, 'ajmer'])->name('muinuddinchisti');
Route::get('/hazratnizamuddin', [HomeController::class, 'delhi'])->name('hazratnizamuddin');
Route::get('/hajiali', [HomeController::class, 'mumbai'])->name('hajiali');
Route::get('/syedmasoodghazi', [HomeController::class, 'bahraich'])->name('syedmasoodghazi');
Route::get('/syedmakhdoom', [HomeController::class, 'kichhauchha'])->name('syedmakhdoom');
Route::get('/aalahazrat', [HomeController::class, 'bareilly'])->name('aalahazrat');
Route::get('/hazratbal', [HomeController::class, 'srinagar'])->name('hazratbal');
Route::get('/hazrattajuddin', [HomeController::class, 'nagpur'])->name('hazrattajuddin');
Route::get('/shahmeenashah', [HomeController::class, 'shahmeenashah'])->name('shahmeenashah');
Route::get('/khammanpeer', [HomeController::class, 'khammanpeer'])->name('khammanpeer');
Route::get('/dataganjbaksh', [HomeController::class, 'lahore'])->name('dataganjbaksh');

Route::get('/muhammad', [HomeController::class, 'mohammad'])->name('muhammad');
Route::get('/hazratmuhammad', [HomeController::class, 'messenger'])->name('hazratmuhammad');
Route::get('/khanaekaaba', [HomeController::class, 'khanaekaaba'])->name('khanaekaaba');
Route::get('/fatima', [HomeController::class, 'fatima'])->name('fatima');
Route::get('/ali', [HomeController::class, 'ali'])->name('ali');
Route::get('/hasan', [HomeController::class, 'hasan'])->name('hasan');
Route::get('/hussain', [HomeController::class, 'hussain'])->name('husain');
Route::get('/khadija', [HomeController::class, 'khadija'])->name('khadija');
Route::get('/aisha', [HomeController::class, 'aisha'])->name('aisha');
Route::get('/hafsa', [HomeController::class, 'hafsa'])->name('hafsa');
Route::get('/ummesalma', [HomeController::class, 'ummesalma'])->name('ummesalma');
Route::get('/abbas', [HomeController::class, 'abbas'])->name('abbas');

// Mecca, Madinah, Links & Policy Routes
Route::get('/aishaalrajhimosque', [HomeController::class, 'aishaalrajhimosque'])->name('aishaalrajhimosque');
Route::get('/aishamosque', [HomeController::class, 'aishamosque'])->name('aishamosque');
Route::get('/alhajaralaswad', [HomeController::class, 'alhajaralaswad'])->name('alhajaralaswad');
Route::get('/alharammosque', [HomeController::class, 'alharammosque'])->name('alharammosque');
Route::get('/aljinnmosque', [HomeController::class, 'aljinnmosque'])->name('aljinnmosque');
Route::get('/alkhaifmosque', [HomeController::class, 'alkhaifmosque'])->name('alkhaifmosque');
Route::get('/alnoormountain', [HomeController::class, 'alnoormountain'])->name('alnoormountain');
Route::get('/alrahmatmountain', [HomeController::class, 'alrahmatmountain'])->name('alrahmatmountain');
Route::get('/alqubaismountain', [HomeController::class, 'alqubaismountain'])->name('alqubaismountain');
Route::get('/altoormountain', [HomeController::class, 'altoormountain'])->name('altoormountain');
Route::get('/arafat', [HomeController::class, 'arafat'])->name('arafat');
Route::get('/mina', [HomeController::class, 'mina'])->name('mina');
Route::get('/muzdalifa', [HomeController::class, 'muzdalifa'])->name('muzdalifa');
Route::get('/jisraljamarat', [HomeController::class, 'jisraljamarat'])->name('jisraljamarat');
Route::get('/jannatalmualla', [HomeController::class, 'jannatalmualla'])->name('jannatalmualla');
Route::get('/badr', [HomeController::class, 'badr'])->name('badr');
Route::get('/birtuwawell', [HomeController::class, 'birtuwawell'])->name('birtuwawell');
Route::get('/makkahmusium', [HomeController::class, 'makkahmusium'])->name('makkahmusium');
Route::get('/bilalbinrabahmosque', [HomeController::class, 'bilalbinrabahmosque'])->name('bilalbinrabahmosque');
Route::get('/nimrahmosque', [HomeController::class, 'nimrahmosque'])->name('nimrahmosque');
Route::get('/alrayahmosque', [HomeController::class, 'alrayahmosque'])->name('alrayahmosque');
Route::get('/gharehira', [HomeController::class, 'gharehira'])->name('gharehira');
Route::get('/zamzamwell', [HomeController::class, 'zamzamwell'])->name('zamzamwell');
Route::get('/exhibitionmosques', [HomeController::class, 'exhibitionmosques'])->name('exhibitionmosques');

Route::get('/madinah', [HomeController::class, 'madinah'])->name('madinah');
Route::get('/hazratmuhammaddome', [HomeController::class, 'hazratmuhammaddome'])->name('hazratmuhammaddome');
Route::get('/jannatulbaqi', [HomeController::class, 'jannatulbaqi'])->name('jannatulbaqi');
Route::get('/alqubamosque', [HomeController::class, 'alqubamosque'])->name('alqubamosque');
Route::get('/alqiblataynmosque', [HomeController::class, 'alqiblataynmosque'])->name('alqiblataynmosque');
Route::get('/mountuhud', [HomeController::class, 'mountuhud'])->name('mountuhud');
Route::get('/ghamamahmosque', [HomeController::class, 'ghamamahmosque'])->name('ghamamahmosque');
Route::get('/anbariyamosque', [HomeController::class, 'anbariyamosque'])->name('anbariyamosque');
Route::get('/wadiejinn', [HomeController::class, 'wadiejinn'])->name('wadiejinn');
Route::get('/jumahmosque', [HomeController::class, 'jumahmosque'])->name('jumahmosque');
Route::get('/daralmadinahmuseum', [HomeController::class, 'daralmadinahmuseum'])->name('daralmadinahmuseum');
Route::get('/hejazrailwaymuseum', [HomeController::class, 'hejazrailwaymuseum'])->name('hejazrailwaymuseum');
Route::get('/quranprintcomplex', [HomeController::class, 'quranprintcomplex'])->name('quranprintcomplex');

Route::get('/abubakr', [HomeController::class, 'abubakrsiddiq'])->name('abubakr');
Route::get('/umar', [HomeController::class, 'umar'])->name('umar');
Route::get('/usman', [HomeController::class, 'usman'])->name('usman');
Route::get('/jafar', [HomeController::class, 'jafar'])->name('jafar');
Route::get('/maymonahbintalharis', [HomeController::class, 'maymonahbintalharis'])->name('maymonahbintalharis');
Route::get('/juwayriyahbintalharis', [HomeController::class, 'juwayriyahbintalharis'])->name('juwayriyahbintalharis');
Route::get('/safiyyahbinthuyayyibnakhtab', [HomeController::class, 'safiyyahbinthuyayyibnakhtab'])->name('safiyyahbinthuyayyibnakhtab');
Route::get('/sawdahbintzamah', [HomeController::class, 'sawdahbintzamah'])->name('sawdahbintzamah');
Route::get('/ummhabibahbintabisufyan', [HomeController::class, 'ummhabibahbintabisufyan'])->name('ummhabibahbintabisufyan');
Route::get('/zaynabbintjahsh', [HomeController::class, 'zaynabbintjahsh'])->name('zaynabbintjahsh');
Route::get('/zaynabbintkhuzayma', [HomeController::class, 'zaynabbintkhuzayma'])->name('zaynabbintkhuzayma');

Route::get('/goodthoughts', [HomeController::class, 'goodthoughts'])->name('goodthoughts');
Route::get('/abubakrmosque', [HomeController::class, 'abubakrmosque'])->name('abubakrmosque');
Route::get('/almadinahmuseum', [HomeController::class, 'almadinahmuseum'])->name('almadinahmuseum');
Route::get('/almasjidalnabawi', [HomeController::class, 'almasjidalnabawi'])->name('almasjidalnabawi');
Route::get('/faqs', [HomeController::class, 'faqs'])->name('faqs');
Route::get('/dosanddonts', [HomeController::class, 'dosanddonts'])->name('dosanddonts');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'storeContact'])->name('contact.store');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/copyright', [HomeController::class, 'copyright'])->name('copyright');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/disclaimer', [HomeController::class, 'disclaimer'])->name('disclaimer');

// Dynamic Service Booking Pages
Route::get('/hotels', [HomeController::class, 'hotels'])->name('hotels');
Route::get('/guesthouse', [HomeController::class, 'hotels'])->name('guesthouse');
Route::get('/hotels/detail/{id?}', [HomeController::class, 'hotelDetail'])->name('hotel.detail');
Route::post('/hotels/checkout/init', [HomeController::class, 'initHotelCheckout'])->name('hotels.checkout.init');
Route::get('/hotels/checkout', [HomeController::class, 'hotelCheckout'])->name('hotels.checkout');
Route::post('/hotels/book', [HomeController::class, 'storeHotelBooking'])->name('hotels.book');
Route::post('/hotels/custom-enquiry', [HomeController::class, 'storeCustomHotelEnquiry'])->name('hotels.custom-enquiry');

Route::get('/cabs', [HomeController::class, 'cabs'])->name('cabs');
Route::get('/cabs/checkout', [HomeController::class, 'cabCheckout'])->name('cabs.checkout');
Route::post('/cabs/checkout/init', [HomeController::class, 'initCabCheckout'])->name('cabs.checkout.init');
Route::post('/cabs/custom-enquiry', [HomeController::class, 'storeCustomCabEnquiry'])->name('cabs.custom-enquiry');
Route::post('/cabs/book', [HomeController::class, 'storeCabBooking'])->name('cabs.book');

Route::get('/shops/cart', [HomeController::class, 'shopCart'])->name('shops.cart');
Route::get('/shops/checkout', [HomeController::class, 'shopCheckout'])->name('shops.checkout');
Route::post('/shops/book', [HomeController::class, 'storeShopOrder'])->name('shops.book');
Route::post('/shops/apply-coupon', [HomeController::class, 'applyCoupon'])->name('shops.coupon');

// Public Reviews & Feedbacks
Route::post('/reviews/store', [HomeController::class, 'storeReview'])->name('reviews.store');
Route::post('/feedback/store', [HomeController::class, 'storeFeedback'])->name('feedback.store');

Route::get('/shops', [HomeController::class, 'shops'])->name('shops');
Route::get('/shops/product/{slug}', [HomeController::class, 'shopProductDetail'])->name('shops.product');
Route::get('/shops/{category}', [HomeController::class, 'shops'])->name('shops.category');

/*
|--------------------------------------------------------------------------
| Hostlok Unified Super Admin Panel Routes (`/admin/...`)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/services/status/update', [AdminDashboardController::class, 'updateServiceStatus'])->name('services.status.update');

    // Hotels Management & CRUD
    Route::get('/hotels/manage', [HotelAdminController::class, 'index'])->name('hotels.index');
    Route::post('/hotels/store', [HotelAdminController::class, 'store'])->name('hotels.store');
    Route::put('/hotels/{id}', [HotelAdminController::class, 'update'])->name('hotels.update');
    Route::post('/hotels/toggle/{id}', [HotelAdminController::class, 'toggleStatus'])->name('hotels.toggle');
    Route::post('/hotels/commission', [HotelAdminController::class, 'updateCommission'])->name('hotels.commission');
    Route::delete('/hotels/{id}', [HotelAdminController::class, 'destroy'])->name('hotels.destroy');
    Route::get('/hotels/bookings', [HotelAdminController::class, 'bookings'])->name('hotels.bookings');
    Route::post('/hotels/bookings/{id}/confirm', [HotelAdminController::class, 'confirmBooking'])->name('hotels.confirm');
    Route::post('/hotels/bookings/{id}/amount', [HotelAdminController::class, 'updateBookingAmount'])->name('hotels.bookings.update-amount');
    Route::post('/hotels/bookings/{id}/update', [HotelAdminController::class, 'updateBooking'])->name('hotels.bookings.update');
    Route::delete('/hotels/bookings/{id}', [HotelAdminController::class, 'destroyBooking'])->name('hotels.bookings.destroy');

    // Cabs Management & CRUD
    Route::get('/cabs/manage', [CabAdminController::class, 'index'])->name('cabs.index');
    Route::post('/cabs/routes/store', [CabAdminController::class, 'storeRoute'])->name('cabs.route.store');
    Route::put('/cabs/routes/{id}', [CabAdminController::class, 'updateRoute'])->name('cabs.route.update');
    Route::post('/cabs/routes/toggle/{id}', [CabAdminController::class, 'toggleRouteStatus'])->name('cabs.route.toggle');
    Route::post('/cabs/vehicles/toggle/{id}', [CabAdminController::class, 'toggleVehicleStatus'])->name('cabs.vehicles.toggle');
    Route::post('/cabs/vehicles/store', [CabAdminController::class, 'storeVehicle'])->name('cabs.vehicles.store');
    Route::put('/cabs/vehicles/{id}', [CabAdminController::class, 'updateVehicle'])->name('cabs.vehicles.update');
    Route::delete('/cabs/vehicles/{id}', [CabAdminController::class, 'destroyVehicle'])->name('cabs.vehicles.destroy');
    Route::post('/cabs/locations/store', [CabAdminController::class, 'storeLocation'])->name('cabs.locations.store');
    Route::put('/cabs/locations/{id}', [CabAdminController::class, 'updateLocation'])->name('cabs.locations.update');
    Route::delete('/cabs/locations/{id}', [CabAdminController::class, 'destroyLocation'])->name('cabs.locations.destroy');
    Route::post('/cabs/erickshaw/toggle', [CabAdminController::class, 'toggleERickshawStatus'])->name('cabs.erickshaw.toggle');
    Route::post('/cabs/parking-policy', [CabAdminController::class, 'updateParkingPolicy'])->name('cabs.parking.update');
    Route::delete('/cabs/{id}', [CabAdminController::class, 'destroy'])->name('cabs.destroy');
    Route::get('/cabs/bookings', [CabAdminController::class, 'bookings'])->name('cabs.bookings');
    Route::post('/cabs/bookings/{id}/assign', [CabAdminController::class, 'assignDriver'])->name('cabs.assign');
    Route::post('/cabs/bookings/{id}/confirm', [CabAdminController::class, 'confirmBooking'])->name('cabs.confirm');
    Route::post('/cabs/bookings/{id}/amount', [CabAdminController::class, 'updateBookingAmount'])->name('cabs.bookings.update-amount');
    Route::post('/cabs/bookings/{id}/update', [CabAdminController::class, 'updateBooking'])->name('cabs.bookings.update');
    Route::delete('/cabs/bookings/{id}', [CabAdminController::class, 'destroyBooking'])->name('cabs.bookings.destroy');

    // Sacred Store Shop Management & CRUD
    Route::get('/shop/manage', [ShopAdminController::class, 'index'])->name('shop.index');
    Route::get('/shop/categories', [ShopAdminController::class, 'categories'])->name('shop.categories');
    Route::post('/shop/categories/store', [ShopAdminController::class, 'storeCategory'])->name('shop.categories.store');
    Route::post('/shop/categories/{id}/update', [ShopAdminController::class, 'updateCategory'])->name('shop.categories.update');
    Route::post('/shop/categories/{id}/toggle', [ShopAdminController::class, 'toggleCategory'])->name('shop.categories.toggle');
    Route::delete('/shop/categories/{id}', [ShopAdminController::class, 'destroyCategory'])->name('shop.categories.destroy');

    Route::post('/shop/products/store', [ShopAdminController::class, 'storeProduct'])->name('shop.product.store');
    Route::put('/shop/products/{id}', [ShopAdminController::class, 'updateProduct'])->name('shop.product.update');
    Route::post('/shop/products/toggle/{id}', [ShopAdminController::class, 'toggleStatus'])->name('shop.product.toggle');
    Route::delete('/shop/{id}', [ShopAdminController::class, 'destroy'])->name('shop.destroy');
    Route::get('/shop/orders', [ShopAdminController::class, 'orders'])->name('shop.orders');
    Route::post('/shop/orders/{id}/dispatch', [ShopAdminController::class, 'dispatchOrder'])->name('shop.dispatch');
    Route::post('/shop/orders/{id}/status', [ShopAdminController::class, 'updateOrderStatus'])->name('shop.order.status');
    Route::post('/shop/orders/{id}/toggle-payment', [ShopAdminController::class, 'togglePaymentStatus'])->name('shop.order.toggle-payment');
    Route::delete('/shop/orders/{id}', [ShopAdminController::class, 'destroyOrder'])->name('shop.order.destroy');

    // Users Management
    Route::get('/users/export', [UserController::class, 'export'])->name('users.export');
    Route::post('/users/toggle/{id}', [UserController::class, 'toggleStatus'])->name('users.toggle');
    Route::resource('users', UserController::class);

    // Email Services & Business Emails
    Route::resource('email-services', EmailServiceController::class);
    Route::get('/free-email-requests', [FreeEmailRequestController::class, 'index'])->name('free-email-requests.index');
    Route::resource('business-emails', BusinessEmailController::class);

    // Blogs & Content
    Route::resource('blogs', BlogController::class);

    // Testimonials
    Route::resource('testimonials', TestimonialController::class);

    // Payments & Gateways & Transactions
    Route::post('/payment-settings/toggle/{id}', [PaymentSettingController::class, 'toggleStatus'])->name('payment-settings.toggle');
    Route::resource('payment-settings', PaymentSettingController::class);
    Route::resource('transactions', TransactionController::class);

    // Invoices & Billing
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/export', [InvoiceController::class, 'export'])->name('invoices.export');
    Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/{id}/download', [InvoiceController::class, 'download'])->name('invoices.download');
    Route::post('/invoices/{id}/send-renewal-reminder', [InvoiceController::class, 'sendRenewalReminder'])->name('invoices.send-renewal-reminder');

    // Promos & Coupons Management
    Route::get('/coupons', [CouponAdminController::class, 'index'])->name('coupons.index');
    Route::get('/coupons/create', [CouponAdminController::class, 'create'])->name('coupons.create');
    Route::post('/coupons/store', [CouponAdminController::class, 'store'])->name('coupons.store');
    Route::get('/coupons/{id}/edit', [CouponAdminController::class, 'edit'])->name('coupons.edit');
    Route::put('/coupons/{id}', [CouponAdminController::class, 'update'])->name('coupons.update');
    Route::delete('/coupons/{id}', [CouponAdminController::class, 'destroy'])->name('coupons.destroy');

    // Support Tickets & Contact Inquiries
    Route::resource('support-tickets', SupportTicketController::class);
    Route::get('/tickets', [TicketAdminController::class, 'index'])->name('tickets.index');
    Route::post('/tickets/{id}/resolve', [TicketAdminController::class, 'resolve'])->name('tickets.resolve');
    Route::post('/tickets/{id}/status', [TicketAdminController::class, 'updateStatus'])->name('tickets.updateStatus');
    Route::post('/tickets/{id}/reply', [TicketAdminController::class, 'reply'])->name('tickets.reply');
    Route::delete('/tickets/{id}', [TicketAdminController::class, 'destroy'])->name('tickets.destroy');

    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts');
    Route::post('/contacts/{id}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
    Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    // Reviews & Customer Ratings (Hotel, Cab, Shop)
    Route::get('/reviews', [ReviewAdminController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/store', [ReviewAdminController::class, 'store'])->name('reviews.store');
    Route::post('/reviews/{id}/update', [ReviewAdminController::class, 'update'])->name('reviews.update');
    Route::post('/reviews/{id}/toggle', [ReviewAdminController::class, 'toggleStatus'])->name('reviews.toggle');
    Route::delete('/reviews/{id}', [ReviewAdminController::class, 'destroy'])->name('reviews.destroy');

    // Customer Feedbacks Management (Hotel, Cab, Shop, General)
    Route::get('/feedbacks', [FeedbackAdminController::class, 'index'])->name('feedbacks.index');
    Route::post('/feedbacks/{id}/toggle', [FeedbackAdminController::class, 'toggleStatus'])->name('feedbacks.toggle');
    Route::delete('/feedbacks/{id}', [FeedbackAdminController::class, 'destroy'])->name('feedbacks.destroy');

    // Customer Directory
    Route::get('/customers', [CustomerAdminController::class, 'index'])->name('customers.index');

    // Profile & Account Settings
    Route::resource('profile', ProfileController::class);
    Route::get('/change-password', [ChangePasswordController::class, 'index'])->name('change.password');
    Route::post('/change-password/store', [ChangePasswordController::class, 'store'])->name('change.password.store');
    Route::get('/change-password/verify', [ChangePasswordController::class, 'verifyForm'])->name('change.password.verify');
    Route::post('/change-password/verify', [ChangePasswordController::class, 'verifyOtp'])->name('change.password.verify.store');

    // Platform Settings
    Route::get('/settings', [SettingController::class, 'general'])->name('settings.index');
    Route::post('/settings/update', [SettingAdminController::class, 'update'])->name('settings.update');
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/general', [SettingController::class, 'general'])->name('general');
        Route::match(['post', 'put'], '/general/update', [SettingController::class, 'updateGeneral'])->name('general.update');

        Route::get('/company', [SettingController::class, 'company'])->name('company');
        Route::match(['post', 'put'], '/company/update', [SettingController::class, 'updateCompany'])->name('company.update');

        Route::get('/contact', [SettingController::class, 'contact'])->name('contact');
        Route::match(['post', 'put'], '/contact/update', [SettingController::class, 'updateContact'])->name('contact.update');
    });
});

/*
|--------------------------------------------------------------------------
| Customer User Portal Routes (`/user/...`)
|--------------------------------------------------------------------------
*/
Route::prefix('user')->middleware('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/hotels', [CustomerPortalController::class, 'hotelBookings'])->name('hotels');
    Route::get('/cabs', [CustomerPortalController::class, 'cabBookings'])->name('cabs');
    Route::get('/orders', [CustomerPortalController::class, 'orders'])->name('orders');
    Route::get('/billing', [CustomerPortalController::class, 'billing'])->name('billing');
    Route::get('/account', [CustomerPortalController::class, 'account'])->name('account');
    Route::post('/account/store', [CustomerPortalController::class, 'updateAccount'])->name('account.store');
    Route::post('/account/password', [CustomerPortalController::class, 'updatePassword'])->name('account.password');
    Route::get('/change-password', [CustomerPortalController::class, 'changePasswordView'])->name('changePassword');
    Route::post('/change-password/store', [CustomerPortalController::class, 'updatePassword'])->name('changePassword.store');
    Route::get('/report-issue', [CustomerPortalController::class, 'reportIssue'])->name('reportIssue');
    Route::post('/report-issue/store', [CustomerPortalController::class, 'storeReportIssue'])->name('reportIssue.store');
    Route::get('/tickets', [CustomerPortalController::class, 'tickets'])->name('tickets');
    Route::get('/tickets/{id}', [CustomerPortalController::class, 'showTicket'])->name('tickets.show');
    Route::delete('/tickets/{id}', [CustomerPortalController::class, 'destroyTicket'])->name('tickets.destroy');
    Route::get('/invoice/{type}/{id}', [CustomerPortalController::class, 'downloadInvoice'])->name('invoice');

    // Customer Own Reviews
    Route::get('/reviews', [CustomerPortalController::class, 'reviews'])->name('reviews');
    Route::post('/reviews/{id}/update', [CustomerPortalController::class, 'updateReview'])->name('reviews.update');
    Route::delete('/reviews/{id}', [CustomerPortalController::class, 'destroyReview'])->name('reviews.destroy');
});
