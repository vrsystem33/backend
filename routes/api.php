<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Address\AddressController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Gallery\GalleryController;
use App\Http\Controllers\Permission\PermissionController;
use App\Http\Controllers\PersonInfo\PersonInfoController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\CategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Subscription\SubscriptionController;
use App\Http\Controllers\Supplier\SupplierController;
use App\Http\Controllers\Supplier\CategoryController as SupplierCategoryController;
use App\Http\Controllers\Carrier\CarrierController;
use App\Http\Controllers\Carrier\CategoryController as CarrierCategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => '/v1'], function () {

    // Route::get('customer/products', [ProductController::class,'@customer']);

    Route::group(['prefix' => '/oauth'], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('change-password', [AuthController::class, 'changePassword'])->middleware(['auth:api', 'check.subscription']);
        Route::post('password-recovery', 'AuthController@passwordRecovery')->name('password.reset');
        Route::get('me', [AuthController::class, 'getAuthenticated'])->middleware(['auth:api', 'check.subscription']);
        Route::post('logout', [AuthController::class, 'logout'])->middleware(['auth:api']);
    });

    // --- Acessos "super"
    Route::group(['prefix' => 'admin'], function () {
        Route::get('', [AdminController::class, 'listing'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);

        Route::get('seed', [AdminController::class, 'seed'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);

        Route::get('migrate', [AdminController::class, 'migrate'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);

        Route::get('clear-cache', [AdminController::class, 'clearCache'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin']);

        Route::get('{id}', [AdminController::class, 'getById'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);

        Route::post('', [AdminController::class, 'create'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);

        Route::put('{id}', [AdminController::class, 'update'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);

        Route::delete('{id}', [AdminController::class, 'delete'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);
    });

    Route::group(['prefix' => 'companies'], function () {
        Route::get('',  [CompanyController::class, 'listing'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);
        Route::get('{id}',  [CompanyController::class, 'getById'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);

        Route::post('', [CompanyController::class, 'create'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);

        Route::put('{id}', [CompanyController::class, 'update'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);

        Route::delete('{id}', [CompanyController::class, 'delete'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);
    });

    Route::group(['prefix' => 'subscriptions'], function () {

        Route::get('', [SubscriptionController::class, 'listing'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);
        Route::get('{id}', [SubscriptionController::class, 'getById'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);

        Route::post('', [SubscriptionController::class, 'create'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);
        Route::post('renew', [SubscriptionController::class, 'renewSubscription'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);
        Route::post('inactive', [SubscriptionController::class, 'inactiveSubscription'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);
        Route::post('cancel', [SubscriptionController::class, 'cancelSubscription'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);

        Route::put('{id}', [SubscriptionController::class, 'update'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);

        Route::delete('{id}', [SubscriptionController::class, 'delete'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);
    });

    Route::group(['prefix' => 'addresses'], function () {
        Route::get('', [AddressController::class, 'listing'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);

        Route::get('{id}', [AddressController::class, 'getById'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin']);

        Route::post('', [AddressController::class, 'create'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);

        Route::put('{id}', [AddressController::class, 'update'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);

        Route::delete('{id}', [AddressController::class, 'delete'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);
    });

    Route::group(['prefix' => 'personInfo'], function () {
        Route::get('', [PersonInfoController::class, 'listing'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);

        Route::get('{id}', [PersonInfoController::class, 'getById'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin']);

        Route::post('', [PersonInfoController::class, 'create'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);

        Route::put('{id}', [PersonInfoController::class, 'update'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);

        Route::delete('{id}', [PersonInfoController::class, 'delete'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super']);
    });

    // --- Acessos voltados para o cliente
    Route::group(['prefix' => 'users'], function () {

        Route::get('', [UserController::class, 'listing'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin,employee', 'check.plan:basic,plus,premium']);
        Route::get('{id}', [UserController::class, 'getById'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin,employee', 'check.plan:basic,plus,premium']);

        Route::post('', [UserController::class, 'create'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::put('{id}', [UserController::class, 'update'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::delete('{id}', [UserController::class, 'delete'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('', [RoleController::class, 'listing'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);
        Route::get('{id}', [RoleController::class, 'getById'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::post('', [RoleController::class, 'create'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::put('{id}', [RoleController::class, 'update'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::delete('{id}', [RoleController::class, 'delete'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);
    });

    Route::group(['prefix' => 'galleries'], function () {

        Route::get('', [GalleryController::class, 'listing'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);
        Route::get('{id}', [GalleryController::class, 'getById'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::post('', [GalleryController::class, 'create'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::put('{id}', [GalleryController::class, 'update'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::delete('{id}', [GalleryController::class, 'delete'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);
    });

    Route::group(['prefix' => 'permissions'], function () {
        Route::get('', [PermissionController::class, 'listing'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::get('{id}', [PermissionController::class, 'getById'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::post('', [PermissionController::class, 'create'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::put('{id}', [PermissionController::class, 'update'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::delete('{id}', [PermissionController::class, 'delete'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);
    });

    Route::group(['prefix' => 'customers'], function () {
        Route::group(['prefix' => 'categories'], function () {
            Route::get('', [CategoryController::class, 'listing'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

            Route::get('{id}', [CategoryController::class, 'getById'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

            Route::post('', [CategoryController::class, 'create'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

            Route::put('{id}', [CategoryController::class, 'update'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

            Route::delete('{id}', [CategoryController::class, 'delete'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);
        });

        Route::get('', [CustomerController::class, 'listing'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::get('{id}', [CustomerController::class, 'getById'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::post('', [CustomerController::class, 'create'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::put('{id}', [CustomerController::class, 'update'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::delete('{id}', [CustomerController::class, 'delete'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);
    });

    Route::group(['prefix' => 'suppliers'], function () {
        Route::group(['prefix' => 'categories'], function () {
            Route::get('', [SupplierCategoryController::class, 'listing'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

            Route::get('{id}', [SupplierCategoryController::class, 'getById'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

            Route::post('', [SupplierCategoryController::class, 'create'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

            Route::put('{id}', [SupplierCategoryController::class, 'update'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

            Route::delete('{id}', [SupplierCategoryController::class, 'delete'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);
        });

        Route::get('', [SupplierController::class, 'listing'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::get('{id}', [SupplierController::class, 'getById'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::post('', [SupplierController::class, 'create'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::put('{id}', [SupplierController::class, 'update'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::delete('{id}', [SupplierController::class, 'delete'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);
    });

    Route::group(['prefix' => 'carriers'], function () {
        Route::group(['prefix' => 'categories'], function () {
            Route::get('', [CarrierCategoryController::class, 'listing'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);
            Route::get('{id}', [CarrierCategoryController::class, 'getById'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);
            Route::post('', [CarrierCategoryController::class, 'create'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);
            Route::put('{id}', [CarrierCategoryController::class, 'update'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);
            Route::delete('{id}', [CarrierCategoryController::class, 'delete'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);
        });

        Route::get('', [CarrierController::class, 'listing'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);
        Route::get('{id}', [CarrierController::class, 'getById'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);
        Route::post('', [CarrierController::class, 'create'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);
        Route::put('{id}', [CarrierController::class, 'update'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);
        Route::delete('{id}', [CarrierController::class, 'delete'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);
    });

    Route::group(['prefix' => 'products'], function () {

        Route::get('', [ProductController::class, 'listing'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin,employee', 'check.plan:basic,plus,premium']);
        Route::get('{id}', [ProductController::class, 'getById'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin,employee', 'check.plan:basic,plus,premium']);

        Route::post('', [ProductController::class, 'create'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::put('{id}', [ProductController::class, 'update'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);

        Route::delete('{id}', [ProductController::class, 'delete'])->middleware(['auth:api', 'check.subscription', 'check.scopes:super,admin', 'check.plan:basic,plus,premium']);
    });
});


Route::middleware('auth:api')->get('teste', function (Request $request) {
    return $request->user();
});
