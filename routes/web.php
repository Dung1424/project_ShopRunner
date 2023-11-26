<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Giao diện người dùng
Auth::routes();
Route::get('/', [\App\Http\Controllers\HomeController::class,"home"]);
Route::match(['get', 'post'], '/contact', [\App\Http\Controllers\HomeController::class, 'contactShop']);
Route::get('/about-us', [\App\Http\Controllers\HomeController::class,"aboutUs"]);

// search product
Route::get('search-product', [\App\Http\Controllers\HomeController::class, 'search'])->name('search-product');

// category
Route::get('/category', [\App\Http\Controllers\HomeController::class,"categoryShop"]);
Route::get('/category/{category:slug}', [\App\Http\Controllers\HomeController::class,"category"]);

// details
Route::get('/details/{product:slug}', [\App\Http\Controllers\HomeController::class,"details"])->name('details');
Route::post('/create', [\App\Http\Controllers\HomeController::class,"create"]);

// add rating/reviews
Route::match(['GET', 'POST'],'/details-rating', [\App\Http\Controllers\RatingController::class,"detailsRating"]);
Route::get('/review/{product:slug}', [\App\Http\Controllers\RatingController::class,"review"]);
Route::post('/add-rating', [\App\Http\Controllers\RatingController::class, 'addRating'])->name('add.rating');


Route::middleware("auth")->group(function (){
// cart
Route::get('/add-to-cart/{product}', [\App\Http\Controllers\HomeController::class,"addToCart"]);
Route::get('/delete-from-cart/{product}', [\App\Http\Controllers\HomeController::class, "deleteFromCart"]);
Route::post('/update-cart/{product}', [\App\Http\Controllers\HomeController::class, "updateCart"]);
Route::get('/clear-cart', [\App\Http\Controllers\HomeController::class, "clearCart"]);
Route::get('/cart', [\App\Http\Controllers\HomeController::class,"cartShop"]);

// check out
Route::get('/check-out', [\App\Http\Controllers\HomeController::class,"checkOut"]);
Route::post('/check-out', [\App\Http\Controllers\HomeController::class,"placeOrder"]);
Route::get('/paypal-success/{order}', [\App\Http\Controllers\HomeController::class,"paypalSuccess"]);
Route::get('/paypal-cancel/{order}', [\App\Http\Controllers\HomeController::class,"paypalCancel"]);

// user : account , trạng thái dơn hàng , danh sách sản phẩm yêu thích
Route::get('/my-order', [\App\Http\Controllers\HomeController::class,"myOrder"]);
Route::get('/my-order-pending', [\App\Http\Controllers\HomeController::class,"myOrderPending"]);
Route::get('/my-order-confirmed', [\App\Http\Controllers\HomeController::class,"myOrderConfirmed"]);
Route::get('/my-order-shipping', [\App\Http\Controllers\HomeController::class,"myOrderShipping"]);
Route::get('/my-order-shipped', [\App\Http\Controllers\HomeController::class,"myOrderShipped"]);
Route::get('/my-order-complete', [\App\Http\Controllers\HomeController::class,"myOrderComplete"]);
Route::get('/my-order-cancel', [\App\Http\Controllers\HomeController::class,"myOrderCancel"]);

Route::get('/order-detail/{order}', [\App\Http\Controllers\HomeController::class,"orderDetail"]);
Route::post('/update-complete/{order}', [\App\Http\Controllers\HomeController::class,"updateComplete"]);
Route::post('update-order-status-cancel/{order}', [\App\Http\Controllers\HomeController::class, "updateOrderStatusCancel"])->name('update_order_status_cancel');
Route::get('/change-password', [\App\Http\Controllers\HomeController::class, 'changePassword'])->name('change-password');
Route::post('/change-password-new', [\App\Http\Controllers\HomeController::class,"updatePassword"])->name('change-password-new');

Route::get('/add-to-favorite', [\App\Http\Controllers\HomeController::class,"addToFavorite"]);
Route::get('/remove-favorite', [\App\Http\Controllers\HomeController::class, "removeFavorite"]);
Route::get('/clear-favorite', [\App\Http\Controllers\HomeController::class, "clearFavorite"]);
Route::get('/favorite-order', [\App\Http\Controllers\HomeController::class,"favoriteOrder"]);

Route::get('/profile', [\App\Http\Controllers\HomeController::class,"Profile"]);
Route::get('/edit-profile', [\App\Http\Controllers\HomeController::class,"EditProfile"]);
Route::post('/edit-profile', [\App\Http\Controllers\HomeController::class, 'updateProfile']);
Route::get('/purchase', [\App\Http\Controllers\HomeController::class,"purchaseHome"]);


// thank you
Route::get('/thank-you/{order}', [\App\Http\Controllers\HomeController::class,"ThankYou"]);
// purchase
Route::get('/purchase/{order}', [\App\Http\Controllers\HomeController::class,"purchaseOrder"]);


});


Route::middleware(["auth","is_admin"])->prefix("admin")->group(function () {
    include_once "admin.php";
});
Route::middleware(["auth","is_employee"])->prefix("employee")->group(function () {
    include_once "employee.php";
});
