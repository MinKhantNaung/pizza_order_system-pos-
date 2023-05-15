<?php

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\User\AjaxController;
use App\Http\Controllers\User\UserController;

Route::middleware('admin_auth')->group(function () {
    // login, register
    Route::redirect('/', '/login-page');
    Route::get('/login-page', [AdminController::class, 'login'])->name('auth.login');
    Route::get('/register-page', [AdminController::class, 'register'])->name('auth.register');
});

Route::middleware(['auth'])->group(function () {
    // admin dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // admin
    Route::middleware(['admin_auth'])->group(function () {
        // categories
        Route::group(['prefix' => 'categories'], function () {
            // list page route
            Route::get('/list', [CategoryController::class, 'list'])->name('categories.list');
            //  create page route
            Route::get('/create', [CategoryController::class, 'createPage'])->name('categories.createPage');
            // for create categories with form
            Route::post('/create', [CategoryController::class, 'create'])->name('categories.create');
            // for edit category page
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
            // for update category
            Route::post('/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
            // for delete categories in list.blade.php
            Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('categories.delete');
        });

        // admin account
        Route::prefix('admin')->group(function () {
            // for password change page
            Route::get('/password/change', [AdminController::class, 'changePasswordPage'])->name('admin.changePasswordPage');
            // for change password
            Route::post('/password/change', [AdminController::class, 'changePassword'])->name('admin.changePassword');
            // for account detail page
            Route::get('/detail', [AdminController::class, 'detail'])->name('admin.detail');
            // for account edit page
            Route::get('/edit', [AdminController::class, 'edit'])->name('admin.edit');
            // for account update
            Route::post('/update/{id}', [AdminController::class, 'update'])->name('admin.update');

            // admin list
            Route::get('/list', [AdminController::class, 'list'])->name('admin.list');
            // for change role otehers admin with Ajax
            Route::get('/change-role', [AdminController::class, 'changeRole'])->name('admin.changeRole');
            // for delete other admin account
            Route::get('/delete/{id}', [AdminController::class, 'delete'])->name('admin.delete');
        });

        // Products
        Route::prefix('products')->group(function () {
            // for products list page
            Route::get('/list', [ProductController::class, 'list'])->name('products.list');
            // for products create page
            Route::get('/create', [ProductController::class, 'createPage'])->name('products.createPage');
            // for create products
            Route::post('/create', [ProductController::class, 'create'])->name('products.create');
            // for products view page
            Route::get('/view/{id}', [ProductController::class, 'view'])->name('products.view');
            // for products update page
            Route::get('/update/{id}', [ProductController::class, 'updatePage'])->name('products.update');
            // for update products
            Route::post('/update/{id}', [ProductController::class, 'update'])->name('products.update');
            // for delete products
            Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('products.delete');
        });

        // Orders
        Route::prefix('orders')->group(function () {
            Route::get('/list', [OrderController::class, 'orderList'])->name('orders.list');
            // for filter and select with form
            Route::get('/change/status', [OrderController::class, 'orderStatus'])->name('orders.status');
            // for submit or change status with ajax
            Route::get('/ajax/change-status', [OrderController::class, 'changeStatus'])->name('orders.changeStatus');
            // for list when click order code
            Route::get('/list-info/{orderCode}', [OrderController::class, 'listInfo'])->name('orders.listInfo');
        });

        // Manage Users
        Route::prefix('users')->group(function () {
            Route::get('/list', [UserListController::class, 'userList'])->name('admin.userList');
            // for change role with ajax
            Route::get('/ajax/change-role', [UserListController::class, 'userChangeRole'])->name('admin.userChangeRole');
            // for delete users
            Route::get('/delete/{id}', [UserListController::class, 'delete'])->name('admin.userDelete');
        });

        // Contacts from users
        Route::get('/contacts/list', [ContactController::class, 'contactList'])->name('admin.contacts');
    });

    // User
    // home
    Route::group(['prefix' => 'users', 'middleware' => 'user_auth'], function () {
        Route::get('/home', [UserController::class, 'home'])->name('users.home');
        // for filter products by categories
        Route::get('/home/filter/{id}', [UserController::class, 'filter'])->name('users.filter');

        // Pizzas
        Route::prefix('pizzas')->group(function () {
            // for details
            Route::get('/detail/{id}', [UserController::class, 'pizzaDetails'])->name('users.pizzaDetails');
        });

        // Password
        Route::prefix('password')->group(function () {
            // for change password page
            Route::get('/change', [UserController::class, 'changePasswordPage'])->name('user.passwordChange');
            // for change password
            Route::post('/change', [UserController::class, 'changePassword'])->name('user.changePassword');
        });

        // Account
        Route::prefix('account')->group(function () {
            // for account change page
            Route::get('/change', [UserController::class, 'changeAccountPage'])->name('user.account');
            // for account change
            Route::post('/change/{id}', [UserController::class, 'changeAccount'])->name('user.accountChange');
        });

        // Cart
        Route::prefix('cart')->group(function () {
            // for cart list
            Route::get('list', [UserController::class, 'cartList'])->name('user.cartList');
        });

        // History
        Route::get('/history', [UserController::class, 'history'])->name('user.history');

        // Contact
        Route::get('/contact', [UserController::class, 'contactPage'])->name('user.contactPage');
        // to contact
        Route::post('/contact', [UserController::class, 'contact'])->name('user.contact');

        // Ajax
        Route::prefix('ajax')->group(function () {
            // for sorting products list
            Route::get('/pizza/list', [AjaxController::class, 'pizzaList'])->name('ajax.pizzaList');
            // for add to cart
            Route::get('/add-to-cart', [AjaxController::class, 'addToCart'])->name('ajax.addToCart');
            // for order
            Route::get('/order', [AjaxController::class, 'order'])->name('ajax.order');
            // for clear order from cart
            Route::get('/clear-cart', [AjaxController::class, 'clearCart'])->name('ajax.clearCart');
            // for clear current product from cart when click cross button
            Route::get('/clear-current-product', [AjaxController::class, 'clearCurrentProduct'])->name('ajax.clearCurrentProduct');
            // for increase view count
            Route::get('/increase-view-count', [AjaxController::class, 'increaseViewCount'])->name('ajax.viewCount');
        });
    });
});

