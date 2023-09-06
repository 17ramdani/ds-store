<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\Whitelist\WhitelistController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Shop\ShopController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Customer\AddressController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DashboardFoController;
use App\Http\Controllers\Member\ProfilController;
use App\Http\Controllers\Pesanan\FreshOrderController;
use App\Http\Controllers\Pesanan\KomplainController;
use App\Http\Controllers\Pesanan\PesananController;

use App\Http\Controllers\Pesanan\ReturController;
use App\Http\Controllers\Shop\CartLacosteController;
use App\Http\Controllers\Shop\ShopCategoryController;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Illuminate\Support\Facades\Cookie;
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

Route::get('/test', function () {
    header('Content-Type: application/json');
    $cartData = Cookie::get('cart');
    $data = json_decode($cartData);
    echo "<pre>";
    echo json_encode($data, JSON_PRETTY_PRINT);
    echo "</pre>";
});
// START E-COMMERCE
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/{id}', [ProductController::class, 'product_by_cat'])->name('shop.product');
Route::get('/shop/detail/{id}', [ProductController::class, 'detail'])->name('shop.detail');
Route::get('/get-price', [ProductController::class, 'getPrice'])->name('get-price');
Route::get('/get-product-modal', [ProductController::class, 'getproductmodal'])->name('get-product-modal');
Route::get('/get-harga-body', [ProductController::class, 'gethargabody'])->name('get-harga-body');
Route::get('/get-harga-accessories', [ProductController::class, 'gethargaaccessories'])->name('get-harga-accessories');
Route::post('/store-to-cart', [ShopController::class, 'store'])->name('store-to-cart');
Route::get('/use-max-acs', [ShopController::class, 'usemaxacs'])->name('use-max-acs');
Route::get('/cart-shop', [CartController::class, 'index'])->name('cart');
//list shop by Jenis
Route::get('/shop/jenis/{id}', [ShopCategoryController::class, 'index'])->name('shop.jenis');

Route::get('/fetch-product', [ProductController::class, 'fetch_product'])->name('fetch-product');

Route::get('/get-notification-badge', [CartController::class, 'getNotificationBadge']);
Route::get('/get-cart-mobile', [CartController::class, 'getCartMobile'])->name('get-cart-mobile');
Route::post('/delete-item', [CartController::class, 'destroy_cart'])->name('delete-item');

Route::post('/wishlist', [WhitelistController::class, 'store_wht'])->name('wishlist');
Route::get('/get-icon-whitelist', [WhitelistController::class, 'getIconsWhitelist']);
Route::get('/get-icon-whitelist-cart', [WhitelistController::class, 'getIconsWhitelistCart']);

Route::post('/whitelist-cart-new', [WhitelistController::class, 'store_wht_cart'])->name('whitelist-cart-new');
Route::get('/get-subkategori/{kategoriId}', [ProductController::class, 'get_subkategori']);

Route::post('/store-to-cart-lacoste', [CartLacosteController::class, 'storeToCookie'])->name('store-to-cart-lacoste');

// END E-COMMERCE

Route::middleware(['auth', 'verified'])->group(function () {

    // E-COMMERCE START
    Route::post('/checkout-cart', [CartController::class, 'updateKeranjangs'])->name('checkout-cart');
    Route::get('/checkout-index', [CartController::class, 'checkout_index'])->name('checkout-index');
    Route::post('/checkout', [CartController::class, 'store'])->name('checkout');

    Route::get('/account-detail', [ProfilController::class, 'account_detail'])->name('account-detail');

    Route::get('/dashboard', [DashboardController::class, 'pesanan_index'])->name('dashboard');
    // Route::get('/dashbord-fo',[DashboardController::class,'fresh_order'])->name('dashboard-fo');
    Route::get('/draft-so/{id}', [PesananController::class, 'drat_so'])->name('draft-so');
    Route::get('/detail-so/{id}', [PesananController::class, 'detail_so'])->name('detail-so');
    Route::patch('/pesanan/done/{id}', [PesananController::class, 'pesanan_done'])->name('pesanan.done');
    Route::get('/pesanan-add-fo', [PesananController::class, 'pesanan_fo'])->name('pesanan-add-fo');
    // Route::post('/store-fo', [PesananController::class, 'store_fo'])->name('store-fo');
    Route::post('/batalkan-pesanan', [PesananController::class, 'pesanan_batal'])->name('batalkan-pesanan');

    //upload
    Route::patch('/upload-bt/{id}', [UploadController::class, 'upload_bt'])->name('upload.bt');

    //retur
    Route::get('/retur/create/{pesanan_id}', [ReturController::class, 'create'])->name('retur.create');
    Route::post('/retur/store/{pesanan_id}', [ReturController::class, 'store'])->name('retur.store');
    //komplain
    Route::get('/komplain/create/{pesanan_id}', [KomplainController::class, 'create'])->name('komplain.create');
    Route::post('/komplain/store/{pesanan_id}', [KomplainController::class, 'store'])->name('komplain.store');
    //FRESH ORDER
    Route::post('order-create', [FreshOrderController::class, 'store'])->name('order.create');
    Route::get('/pesanan-add-dev', [FreshOrderController::class, 'pesanan_dev'])->name('pesanan-add-dev');
    Route::get('/dashbord-fo', [DashboardFoController::class, 'index'])->name('dashboard-fo');
    Route::get('/fresh-order-detail/{id}', [FreshOrderController::class, 'detail'])->name('fo.detail');
    //ADDRESS
    Route::resource('address', AddressController::class);
});


require __DIR__ . '/auth.php';
