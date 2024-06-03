<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProvisionServer;
use Illuminate\Support\Facades\Auth;


    // route updateProfileAdmin
    Route::post('/profileAdmin', [ProvisionServer::class, 'updateProfileAdmin'])->name('profileAdmin');

    //rotue logout 
    Route::get('/logout', [ProvisionServer::class, 'logout']);

    // route Dashboard
    Route::get('/Dashboard', [ProvisionServer::class, 'getStatistics']);

    // route updateProfileUser
    Route::post('/profileUser', [ProvisionServer::class, 'updateProfile'])->name('profileUser');

    // route hiển thị trang index khi chạy lên đầu tiên 
    Route::get('/{page?}', [ProvisionServer::class, 'page'])->name('index');

    // route hiển thị trang Dashboard khi chạy lên đầu tiên 
    Route::get('/Dashboard/{admin?}', [ProvisionServer::class, 'admin'])->name('Dashboard');

    // route hiển thị sản phẩm của nhà sản xuất 
    Route::get('/manufacturer/{id}', [ProvisionServer::class, 'showManufacturerProducts']);

    // route sắp xếp sản phẩm theo giá , tên 
    Route::post('/sort-products', [ProvisionServer::class, 'sortProducts']);


    // route hiển thị sản phẩm của protypes
    Route::get('/product-type/{id}', [ProvisionServer::class, 'showProductsByType']);


    // route tìm kiếm sản phẩm 
    Route::post('/search_products', [ProvisionServer::class, 'search']);
    // route tìm kiếm sản phẩm trang admin
    Route::post('/search_products_admin', [ProvisionServer::class, 'searchAdmin']);
    // route tìm kiếm nhà sản xuất trang admin 
    Route::post('/search_manufactures', [ProvisionServer::class, 'searchManu']);
    // route tìm kiếm loại sản phẩm trang admin 
    Route::post('/search_protype', [ProvisionServer::class, 'searchProtype']);
    // route tìm kiếm user trang admin 
    Route::post('/search_user', [ProvisionServer::class, 'searchUser']);

    //route CRUD product
    Route::post('/AddProduct', [ProvisionServer::class, 'addProduct'])->name('addProduct');
    Route::post('/AddProduct', [ProvisionServer::class, 'storeProduct'])->name('addProduct');
    Route::get('/EditProduct/{id}', [ProvisionServer::class, 'editProduct'])->name('editProduct');
    Route::post('/EditProduct/{id}', [ProvisionServer::class, 'updateProduct'])->name('updateProduct');
    Route::delete('deleteProduct/{id}', [ProvisionServer::class, 'deleteProduct'])->name('deleteProduct');

    //Route CRUD protype
    Route::post('/AddProductType', [ProvisionServer::class, 'addProtype'])->name('addProtype');
    Route::post('/AddProductType', [ProvisionServer::class, 'storeProtype'])->name('addProtype');
    Route::get('/EditProductType/{id}', [ProvisionServer::class, 'editProtype'])->name('editProtype');
    Route::post('/EditProductType/{id}', [ProvisionServer::class, 'updateProtype'])->name('updateProtype');
    Route::delete('deleteProtype/{id}', [ProvisionServer::class, 'deleteProtype'])->name('deleteProtype');

    //Route CRUD Manu
    Route::post('/AddManufactures', [ProvisionServer::class, 'addManu'])->name('addManu');
    Route::post('/AddManufactures', [ProvisionServer::class, 'storeManu'])->name('addManu');
    Route::get('/EditManufactures/{id}', [ProvisionServer::class, 'editManu'])->name('editManu');
    Route::post('/EditManufactures/{id}', [ProvisionServer::class, 'updateManu'])->name('updateManu');
    Route::delete('deleteManu/{id}', [ProvisionServer::class, 'deleteManu'])->name('deleteManu');

    //Route CRUD User
    Route::post('/AddUser', [ProvisionServer::class, 'addUser'])->name('addUser');
    Route::post('/AddUser', [ProvisionServer::class, 'storeUser'])->name('addUser');
    Route::get('/EditUser/{id}', [ProvisionServer::class, 'editUser'])->name('editUser');
    Route::post('/EditUser/{id}', [ProvisionServer::class, 'updateUser'])->name('updateUser');
    Route::delete('deleteUser/{id}', [ProvisionServer::class, 'deleteUser'])->name('deleteUser');

    //Route Detail Product
    Route::get('ProductDetail/{id}', [ProvisionServer::class, 'showproduct'])->name('showproduct');

    // route incrementView
    Route::post('/product/{id}/view', [ProvisionServer::class, 'incrementView']);

    // route register
    Route::post('/register', [ProvisionServer::class, 'register'])->name('register');
    //route login 
    Route::get('/login', [ProvisionServer::class, 'showLoginForm'])->name('login');
    Route::post('/login', [ProvisionServer::class, 'login'])->name('login');

    // route thêm sản phẩm vào giỏ hàng 
    Route::post('add-to-cart/{id}', [ProvisionServer::class, 'addToCart'])->name('add.to.cart');

    // route update quantity cart
    Route::post('/update-cart/{productId}', [ProvisionServer::class, 'updateCartQuantity']);

    // route delete product cart 
    Route::post('/delete-from-cart/{productId}',  [ProvisionServer::class, 'deleteFromCart']);

    // route delete all product cart
    Route::post('/delete-all-from-cart', [ProvisionServer::class, 'deleteAllFromCart']);

    // abate all product cart 
    Route::post('/checkout', [ProvisionServer::class, 'checkout']);

    // route review product
    Route::post('/review', [ProvisionServer::class, 'store'])->name('review.store');

    //route update cart
    Route::post('/update-cart-totals/{productId}', [ProvisionServer::class, 'updateCartTotals'])->name('update-cart-totals');

