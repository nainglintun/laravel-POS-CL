<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\User\AjaxController;
use App\Http\Controllers\User\UserController;

//for pizza order system
Route::middleware(['admin_auth'])->group(function (){
    //login, register
Route::redirect('/','loginPage');
Route::get('loginPage',[AuthController::class,'loginPage'])->name('auth#loginPage');
Route::get('registerPage',[AuthController::class,'registerPage'])->name('auth#registerPage');
});


// middleware section
Route::middleware(['auth'])->group(function () {
      // dashboard
      Route::get('dashboard',[AuthController::class,'dashboard'])->name('dashboard');

    // admin
    // Route::group(['middle'=>'admin_auth'],function(){

    // });

    // another way to protect the middleware
    Route::middleware(['admin_auth'])->group(function(){

          //category using route group
         Route::group(['prefix'=>'category'],function(){
        Route::get('list',[CategoryController::class,'list'])->name('category#list');
        Route::get('create/page',[CategoryController::class,'createPage'])->name('category#createPage');
        //for create category button
        Route::post('create',[CategoryController::class,'create'])->name('category#create');

        //for carrying id number to delete in each category list item.
        Route::get('delete/{id}',[CategoryController::class,'delete'])->name('category#delete');

        // for editing category page.
        Route::get('edit/{id}',[CategoryController::class,'edit'])->name('category#edit');

        // for updating category page
        Route::post('update',[CategoryController::class,'update'])->name('category#update');      

       });

       // ‌admin account
       Route::prefix('admin')->group(function(){
            Route::get('password/changePage',[AdminController::class,'changePasswordPage'])->name('admin#changePasswordPage');
            Route::post('change/password',[AdminController::class,'changePassword'])->name('admin#changePassword');

            //account->details
            Route::get('details',[AdminController::class,'details'])->name('admin#details');

            //account->editpfrofile
            Route::get('admin/editProfile',[AdminController::class,'editProfile'])->name('admin#editProfile');

            // account ->update profile 
            Route::post('admin/updateProfile/{id}',[AdminController::class,'updateProfile'])->name('admin#update');

            //admin>admin-list
            Route::get('list',[AdminController::class,'list'])->name('admin#list');
            Route::get('delete/{id}',[AdminController::class,'delete'])->name('admin#delete');

            //change admin role
            Route::get('changeRole/{id}',[AdminController::class,'changeRole'])->name('admin#changeRole');

            // change role function
            Route::post('change/role/{id}',[AdminController::class,'change'])->name('admin#change');
            
       });

       //products
       Route::prefix('product')->group(function(){
        //listPage
        Route::get('list',[ProductController::class,'list'])->name('product#list');
        // createpage
        Route::get('product/createpage',[ProductController::class,'createPage'])->name('product#createPage');
        // create function page
        Route::post('product/create',[ProductController::class,'create'])->name('product#create');

        // delete each pizza product
        Route::get('delete/{id}',[ProductController::class,'delete'])->name('product#delete');

        // edit each pizza product
       Route::get('edit/{id}',[ProductController::class,'edit'])->name('product#edit');

       // show for update page
       Route::get('product/updatePizza/{id}',[ProductController::class,'updatePizzaPage'])->name('product#updatePage');
       
       // to update function
       Route::post('update',[ProductController::class,'updatePizza'])->name('product#update');

       });
    });


     //order
       Route::prefix('order')->group(function(){
            Route::get('list',[OrderController::class,'orderList'])->name('admin#orderList');
            
            
       
    });

    // user -> home
    route::group(['prefix'=>'user','middleware'=>'user_auth'],function(){
        // Route::get('home',function(){
        //     return view('user.home');
        // })->name('user#home');
        

        Route::get('/homePage',[UserController::class,'home'])->name('user#home');
        // filter cateogry list by pizza category
        Route::get('/filter/{id}',[UserController::class,'filter'])->name('user#filter');
       // route to go the history page.
       Route::get('/history',[UserController::class,'history'])->name('user#history');

        // detail pizza with style
        route::prefix('cart')->group(function(){
            Route::get('list',[UserController::class,'cartList'])->name('user#cartList');            
        });
       
        // for cart detail
        // detail pizza with style
        route::prefix('pizza')->group(function(){
            Route::get('/detail/{id}',[UserController::class,'detail'])->name('user#detail');
            
        });

        // change password 
        Route::prefix('password')->group(function(){
            //go to change password page
            Route::get('/changePassword',[UserController::class,'changePassword'])->name('user#changePassword');
            //to do change password function
            Route::post('/changePassword',[UserController::class,'changePasswordWork'])->name('user#changePasswordWork');
        });


        //user>account route group
        Route::prefix('account')->group(function(){
            //go to change password page
            Route::get('/change',[UserController::class,'accountChangePage'])->name('user#accountChangePage');
            //to do account change function
            Route::post('/change/{id}',[UserController::class,'accountChange'])->name('user#accountChange');

            
        });

        // using ajax 
        Route::prefix('ajax')->group(function(){
                // Route::get('pizzaList',function(){
                //     $data=Product::get();
                //     return $data;
                // });


                //pizza list
                Route::get('pizza/List',[AjaxController::class,'pizzaList'])->name('ajax#pizzaList');
                Route::get('addToCart',[AjaxController::class,'addToCart'])->name('ajax#addToCart');
                Route::get('order',[AjaxController::class,'order'])->name('ajax#order');
                Route::get('clear/cart',[AjaxController::class,'clearCart'])->name('ajax#clearCart');
                Route::get('clear/current/product',[AjaxController::class,'clearCurrentProduct'])->name('clearCurrentProduct');



        });


    });


    




});