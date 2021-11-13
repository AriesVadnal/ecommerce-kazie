<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\ShippingAreaController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\User\AllUserController;
use App\Http\Controllers\User\CartPageController;
use App\Http\Controllers\User\CashController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\StripeController;
use App\Http\Controllers\User\WishlistController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['prefix'=> 'admin', 'middleware'=>['admin:admin']], function(){
	Route::get('/login', [AdminController::class, 'loginForm']);
	Route::post('/login',[AdminController::class, 'store'])->name('admin.login');
});

Route::middleware(['auth:admin'])->group(function(){

Route::middleware(['auth:sanctum,admin', 'verified'])->get('/admin/dashboard', function () {
    return view('admin.index');
})->name('dashboard');

Route::get('/admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');
Route::get('/admin/profile', [AdminProfileController::class, 'AdminProfile'])->name('admin.profile');
Route::get('/admin/profile/edit', [AdminProfileController::class, 'AdminProfileEdit'])->name('admin.profile.edit');
Route::post('/admin/profile/store', [AdminProfileController::class, 'AdminProfileStore'])->name('admin.profile.store');
Route::get('/admin/change/password', [AdminProfileController::class, 'AdminChangePassword'])->name('admin.change.password');
Route::post('/admin/update/password', [AdminProfileController::class, 'AdminUpdateChangePassword'])->name('update.change.password');

});


Route::middleware(['auth:sanctum,web', 'verified'])->get('/dashboard', function () {
    $id = Auth::user()->id;
    $user = User::find($id);
    return view('dashboard', compact('user'));
})->name('dashboard');

Route::get('/',[IndexController::class, 'index']);
Route::get('/user/logout',[IndexController::class, 'UserLogout'])->name('user.logout');
Route::get('/user/profile', [IndexController::class, 'UserProfile'])->name('user.profile');
Route::post('/user/profile/store', [IndexController::class, 'UserProfileStore'])->name('user.profile.store');
Route::get('/user/change/password', [IndexController::class, 'UserChangePassword'])->name('change.password');
Route::post('/user/password/update', [IndexController::class, 'UserPasswordUpdate'])->name('user.password.update');

Route::prefix('brand')->group(function(){
    Route::get('/view',[BrandController::class, 'BrandView'])->name('all.brand');
    Route::post('/store',[BrandController::class, 'BrandStore'])->name('brand.store');
    Route::get('/edit/{id}',[BrandController::class, 'BrandEdit'])->name('brand.edit');
    Route::post('/update',[BrandController::class, 'BrandUpdate'])->name('brand.update');
    Route::get('/delete/{id}',[BrandController::class, 'BrandDelete'])->name('brand.delete');
});

Route::prefix('category')->group(function(){

    // Category 
    Route::get('/view',[CategoryController::class, 'CategoryView'])->name('view.category');
    Route::post('/store',[CategoryController::class, 'CategoryStore'])->name('category.store');
    Route::get('/edit/{id}',[CategoryController::class, 'CategoryEdit'])->name('category.edit');
    Route::post('/update/{id}',[CategoryController::class, 'CategoryUpdate'])->name('category.update');
    Route::get('/delete/{id}',[CategoryController::class, 'CategoryDelete'])->name('category.delete');

    // Sub Category
    Route::get('/sub/view',[SubCategoryController::class, 'SubCategoryView'])->name('all.subcategory');
    Route::post('/sub/store',[SubCategoryController::class, 'SubCategoryStore'])->name('subcategory.store');
    Route::get('/sub/edit/{id}',[SubCategoryController::class, 'SubCategoryEdit'])->name('subcategory.edit');
    Route::post('/sub/update/{id}',[SubCategoryController::class, 'SubCategoryUpdate'])->name('subcategory.update');
    Route::get('/sub/delete/{id}',[SubCategoryController::class, 'SubCategoryDelete'])->name('subcategory.delete');

    // Sub Sub Category
    Route::get('/sub/sub/view',[SubCategoryController::class, 'SubSubCategoryView'])->name('all.subsubcategory');
    Route::get('/subcategory/ajax/{category_id}',[SubCategoryController::class, 'GetSubCategory']);
    Route::get('/sub-subcategory/ajax/{subcategory_id}', [SubCategoryController::class, 'GetSubSubCategory']);
    Route::post('/sub/sub/store',[SubCategoryController::class, 'SubSubCategoryStore'])->name('subsubcategory.store');
    Route::get('/sub/sub/edit/{id}',[SubCategoryController::class, 'SubSubCategoryEdit'])->name('subsubcategory.edit');
    Route::post('/sub/sub/update/{id}',[SubCategoryController::class, 'SubSubCategoryUpdate'])->name('subsubcategory.update');
    Route::get('/sub/sub/delete/{id}',[SubCategoryController::class, 'SubSubCategoryDelete'])->name('subsubcategory.delete');

});


Route::prefix('product')->group(function(){

    Route::get('/add',[ProductController::class, 'AddProduct'])->name('add-product');
    Route::post('/store',[ProductController::class, 'ProductStore'])->name('product-store');
    Route::get('/manage',[ProductController::class, 'ManageProduct'])->name('manage-product');
    Route::get('/edit/{id}',[ProductController::class, 'EditProduct'])->name('product.edit');
    Route::post('/data/update/{id}',[ProductController::class, 'ProductDataUpdate'])->name('product-update');
    Route::post('/image/update',[ProductController::class, 'MultiImageUpdate'])->name('update-product-image');
    Route::post('/thambnail/update', [ProductController::class, 'ThambnailImageUpdate'])->name('update-product-thambnail');
    Route::get('/multiImg/delete/{id}', [ProductController::class, 'MultiImageDelete'])->name('product.multiImg.delete');
    Route::get('/inactive/{id}', [ProductController::class, 'ProductInactive'])->name('product.inactive');
    Route::get('/active/{id}', [ProductController::class, 'ProductActive'])->name('product.active');
    Route::get('/delete/{id}', [ProductController::class, 'ProductDelete'])->name('product.delete');
});


Route::prefix('slider')->group(function(){

    Route::get('/view', [SliderController::class, 'SliderView'])->name('manage-slider');
    Route::post('/store', [SliderController::class, 'SliderStore'])->name('slider.store');
    Route::get('/edit/{id}',[SliderController::class, 'SliderEdit'])->name('slider.edit');
    Route::post('/update/{id}', [SliderController::class, 'SliderUpdate'])->name('slider.update');
    Route::get('/delete/{id}',[SliderController::class, 'SliderDelete'])->name('slider.delete');
    Route::get('/inactive/{id}',[SliderController::class, 'SliderInactive'])->name('slider.inactive');
    Route::get('/active/{id}',[SliderController::class, 'SliderActive'])->name('slider.active');
});

Route::get('/language/hindi', [LanguageController::class, 'Hindi'])->name('hindi.language');
Route::get('/language/english', [LanguageController::class, 'English'])->name('english.language');

Route::get('/product/details/{id}/{slug}',[IndexController::class, 'ProductDetails']);
Route::get('/product/tag/{tag}', [IndexController::class, 'TagWiseProduct']);

Route::get('/subcategory/product/{subcat_id}/{slug}',[IndexController::class, 'SubCatWiseProduct']);
Route::get('/subsubcategory/product/{subsubcat_id}/{slug}',[IndexController::class, 'SubSubCatWiseProduct']);
Route::get('/product/view/modal/{id}',[IndexController::class, 'ProductViewAjax']);
Route::post('/cart/data/store/{id}',[CartController::class, 'AddToCart']);
Route::get('/product/mini/cart',[CartController::class, 'AddMiniCart']);
Route::get('/minicart/product-remove/{rowId}',[CartController::class, 'RemoveMiniCart']);
Route::post('/add-to-wishlist/{product_id}',[CartController::class, 'AddToWishlist']);

Route::group(['prefix' => 'user','middleware' => ['user','auth'], 'namespace' => 'User'], function(){
    Route::get('/wishlist',[WishlistController::class, 'ViewWishlist'])->name('wishlist');
    Route::get('/get-wishlist-product',[WishlistController::class, 'GetWishlistProduct']);
    Route::get('/wishlist-remove/{id}', [WishlistController::class, 'RemoveWishlistProduct']);
    Route::post('/stripe/order',[StripeController::class, 'StripeOrder'])->name('stripe.order');

    Route::get('/my/orders',[AllUserController::class, 'MyOrders'])->name('my.order');
    Route::get('/order_details/{order_id}',[AllUserController::class, 'OrderDetails']);
    Route::post('/cash/order',[CashController::class, 'CashOrder'])->name('cash.order');
    Route::get('/invoice-download/{order_id}',[AllUserController::class, 'InvoiceDownload']);

    Route::post('/return/order/{order_id}',[AllUserController::class, 'ReturnOrder'])->name('return.order');
    Route::get('/return/order/list',[AllUserController::class, 'ReturnOrderList'])->name('return.order.list');
    Route::get('/cancel/orders',[AllUserController::class, 'CancelOrders'])->name('cancel.orders');
});

    Route::get('/mycart',[CartPageController::class, 'MyCart'])->name('MyCart');
    Route::get('/get-cart-product',[CartPageController::class, 'GetCartProduct']);
    Route::get('/cart-remove/{id}',[CartPageController::class, 'RemoveCartProduct']);

    Route::get('/cart-increment/{rowId}',[CartPageController::class, 'CartIncrement']);
    Route::get('/cart-decrement/{rowId}',[CartPageController::class, 'CartDecrement']);


Route::prefix('coupons')->group(function(){
    Route::get('/view', [CouponController::class, 'CouponView'])->name('manage-coupon');
    Route::post('/store', [CouponController::class, 'CouponStore'])->name('coupon.store');
    Route::get('/edit/{id}',[CouponController::class, 'CouponEdit'])->name('coupon.edit');
    Route::post('/update/{id}',[CouponController::class, 'CouponUpdate'])->name('coupon.update');
    Route::get('/delete/{id}',[CouponController::class, 'CouponDelete'])->name('coupon.delete');
});

Route::prefix('shipping')->group(function(){
    Route::get('/division/view',[ShippingAreaController::class, 'DivisionView'])->name('manage-division');
    Route::post('/division/store',[ShippingAreaController::class, 'DivisionStore'])->name('division.store');
    Route::get('/division/edit/{id}',[ShippingAreaController::class, 'DivisionEdit'])->name('division.edit');
    Route::post('/division/update/{id}',[ShippingAreaController::class, 'DivisionUpdate'])->name('division.update');
    Route::get('/division/delete/{id}',[ShippingAreaController::class, 'DivisionDelete'])->name('division.delete');
    
    Route::get('/district/view',[ShippingAreaController::class, 'DistrictView'])->name('manage-district');
    Route::post('/district/store',[ShippingAreaController::class, 'DistrictStore'])->name('district.store');
    Route::get('/district/edit/{id}',[ShippingAreaController::class, 'DistrictEdit'])->name('district.edit');
    Route::post('/district/update/{id}',[ShippingAreaController::class, 'DistrictUpdate'])->name('district.update');
    Route::get('/district/delete/{id}',[ShippingAreaController::class, 'DistrictDelete'])->name('district.delete');

    Route::get('/state/view',[ShippingAreaController::class, 'StateView'])->name('manage-state');
    Route::post('/state/store',[ShippingAreaController::class, 'StateStore'])->name('state.store');
    Route::get('/state/edit/{id}',[ShippingAreaController::class, 'StateEdit'])->name('state.edit');
    Route::post('/state/update/{id}',[ShippingAreaController::class, 'StateUpdate'])->name('state.update');
    Route::get('/state/delete/{id}',[ShippingAreaController::class, 'StateDelete'])->name('state.delete');
});

Route::post('/coupon-apply',[CartController::class, 'CouponApply']);
Route::get('/coupon-calculation',[CartController::class, 'CouponCalculation']);
Route::get('/coupon-remove',[CartController::class, 'CouponRemove']);

Route::get('/checkout',[CartController::class, 'CheckoutCreate'])->name('checkout');
Route::get('/district-get/ajax/{division_id}',[CheckoutController::class, 'DistrictGetAjax']);
Route::get('/get-state/ajax/{district_id}',[CheckoutController::class, 'StateGetAjax']);
Route::post('/checkout/store',[CheckoutController::class, 'CheckoutStore'])->name('checkout.store');

Route::prefix('orders')->group(function(){
    Route::get('/pending/orders', [OrderController::class, 'PendingOrders'])->name('pending-order');
    Route::get('/pending/order/details/{id}',[OrderController::class, 'PendingOrdersDetails'])->name('pending.order.details');
    Route::get('/confirmend/orders',[OrderController::class, 'ConfirmendOrders'])->name('confirmend-order');
    Route::get('/procession/orders',[OrderController::class, 'ProcessingOrders'])->name('processiong-orders');
    Route::get('/picked/orders',[OrderController::class, 'PickedOrders'])->name('picked-orders');
    Route::get('/shipped/orders',[OrderController::class, 'ShippedOrder'])->name('shipped-orders');
    Route::get('/delivered/orders',[OrderController::class, 'DeliveredOrder'])->name('delivered-orders');
    Route::get('/cancel/orders',[OrderController::class, 'CancelOrder'])->name('cancel-orders');

    Route::get('/pending/confirm/{order_id}',[OrderController::class, 'PendingToConfirm'])->name('pending-confirm');
    Route::get('/confirm/processing/{order_id}',[OrderController::class, 'ConfirmToProcessing'])->name('confirm.processing');
    Route::get('/processing/picked/{order_id}',[OrderController::class, 'ProcesssingToPicked'])->name('processing.picked');
    Route::get('/picked/shipped/{order_id}',[OrderController::class, 'PickedToShipped'])->name('picked.shipped');
    Route::get('/shipped/delivered/{order_id}',[OrderController::class, 'ShippedToDelivered'])->name('shipped.delivered');
    Route::get('/delivered/cancel/{order_id}',[OrderController::class, 'DeliveredToCancel'])->name('delivered.cancel');
    Route::get('/invoice/download/{id}',[OrderController::class, 'AdminInvoiceDownload'])->name('invoice.download');
});

Route::prefix('reports')->group(function(){
    Route::get('/view',[ReportController::class, 'ReportView'])->name('all-reports');
    Route::post('/search/by/date',[ReportController::class, 'ReportByDate'])->name('search-by-date');
    Route::post('/search/by/month',[ReportController::class, 'ReportByMonth'])->name('search-by-mouth');
    Route::post('/search/by/year',[ReportController::class, 'ReportByYear'])->name('search-by-year');
});

Route::prefix('allUser')->group(function(){
    Route::get('/view',[AdminProfileController::class, 'AllUsers'])->name('all-users');
});
