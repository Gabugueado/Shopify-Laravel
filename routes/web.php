<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShopifyAuthController;
use App\Http\Controllers\ShopifyDataController;

use Illuminate\Http\Request as ClientRequest;
use Illuminate\Support\Facades\Auth;


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::prefix('shopify')->group(function () {
        Route::get('/install', [ShopifyAuthController::class, 'install'])->name('shopify.install');
        Route::get('/callback', [ShopifyAuthController::class, 'callback'])->name('shopify.callback');
        Route::get('/products', [ShopifyDataController::class, 'products'])->name('shopify.products');
        Route::get('/orders-30d', [ShopifyDataController::class, 'ordersLast30Days'])->name('shopify.orders30d');
    });
});

Route::get('/', function () { return redirect('/dashboard'); });
Route::get('/register',  [RegisterController::class, 'showRegisterForm'])->name('getRegister');
Route::post('/register', [RegisterController::class, 'register'])->name('postRegister');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('postLogin');
Route::post('/logout', function (ClientRequest $request){
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');
Route::get('/shopify/products/export/excel', [ShopifyDataController::class, 'exportExcel'])->name('shopify.export.excel');
Route::get('/shopify/products/export/csv', [ShopifyDataController::class, 'exportCsv'])->name('shopify.export.csv');
