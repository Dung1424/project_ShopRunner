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
Route::get('/add-to-cart/{product}', [\App\Http\Controllers\CartController::class,"addToCart"]);
Route::get('/delete-from-cart/{product}', [\App\Http\Controllers\CartController::class, "deleteFromCart"]);
Route::post('/update-cart/{product}', [\App\Http\Controllers\CartController::class, "updateCart"]);
Route::get('/clear-cart', [\App\Http\Controllers\CartController::class, "clearCart"]);
Route::get('/cart', [\App\Http\Controllers\CartController::class,"cartShop"]);

// check out
Route::get('/check-out', [\App\Http\Controllers\PaymentOrdersController::class,"checkOut"]);
Route::post('/check-out', [\App\Http\Controllers\PaymentOrdersController::class,"placeOrder"]);
Route::get('/paypal-success/{order}', [\App\Http\Controllers\PaymentOrdersController::class,"paypalSuccess"]);
Route::get('/paypal-cancel/{order}', [\App\Http\Controllers\PaymentOrdersController::class,"paypalCancel"]);

// user : account , trạng thái dơn hàng , danh sách sản phẩm yêu thích
Route::get('/my-order', [\App\Http\Controllers\MyOrderController::class,"myOrder"]);
Route::get('/my-order-pending', [\App\Http\Controllers\MyOrderController::class,"myOrderPending"]);
Route::get('/my-order-confirmed', [\App\Http\Controllers\MyOrderController::class,"myOrderConfirmed"]);
Route::get('/my-order-shipping', [\App\Http\Controllers\MyOrderController::class,"myOrderShipping"]);
Route::get('/my-order-shipped', [\App\Http\Controllers\MyOrderController::class,"myOrderShipped"]);
Route::get('/my-order-complete', [\App\Http\Controllers\MyOrderController::class,"myOrderComplete"]);
Route::get('/my-order-cancel', [\App\Http\Controllers\MyOrderController::class,"myOrderCancel"]);
Route::get('/order-detail/{order}', [\App\Http\Controllers\MyOrderController::class,"orderDetail"]);
Route::post('/update-complete/{order}', [\App\Http\Controllers\MyOrderController::class,"updateComplete"]);
Route::post('update-order-status-cancel/{order}', [\App\Http\Controllers\MyOrderController::class, "updateOrderStatusCancel"])->name('update_order_status_cancel');

Route::get('/change-password', [\App\Http\Controllers\ChangePasswordController::class, 'changePassword'])->name('change-password');
Route::post('/change-password-new', [\App\Http\Controllers\ChangePasswordController::class,"updatePassword"])->name('change-password-new');

Route::get('/add-to-favorite', [\App\Http\Controllers\FavoriteController::class,"addToFavorite"]);
Route::get('/remove-favorite', [\App\Http\Controllers\FavoriteController::class, "removeFavorite"]);
Route::get('/clear-favorite', [\App\Http\Controllers\FavoriteController::class, "clearFavorite"]);
Route::get('/favorite-order', [\App\Http\Controllers\FavoriteController::class,"favoriteOrder"]);

Route::get('/profile', [\App\Http\Controllers\ProfileController::class,"Profile"]);
Route::get('/edit-profile', [\App\Http\Controllers\ProfileController::class,"EditProfile"]);
Route::post('/edit-profile', [\App\Http\Controllers\ProfileController::class, 'updateProfile']);



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
