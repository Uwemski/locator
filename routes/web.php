<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get("/home", function(){
    return view('index');
})->name("homepage");

Route::get("/userReg", function(){
    return view('user.userReg');
})->name('userReg');

Route::get("/userLogin", function(){
    return view("user.userLogin");
})->name("userLogin");

Route::get("/userDashboard", function(){
    return view("user.dashboard");
})->name('userDashboard');

Route::get('/test', function(){
    return view('user.test');
})->name('Testing');

Route::get('/parish_reg', function(){
    return view('parish.parish_reg');
})->name('parish_reg');


//routes for admin
Route::get('/admin/test', function(){
    return view('admin.admin_test');
})->name('admin_test');

Route::get('/admin/login', function(){
    return view('admin.admin_login');
})->name('admin_login');

Route::get('/admin/create_admin', function(){
    return view('admin.create_admin');
})->name('admin_create');

Route::get('/adminDashboard', function(){
    return view("admin.admin_dashboard");
})->name("adminDashboard");

Route::get('/admin/viewUsers', function(){
    return view('admin.all_users');
})->name('allUsers');

Route::get('/admin/viewParishes', function(){
    return view('admin.all_parish');
})->name('allParishes');

//admin controllers
Route::post('/admin/login', [AdminController::class, 'login']);

Route::post('/admin/create_admin', [AdminController::class, 'register']);

Route::post('/adminLogout', [AdminController::class, 'logout']);

//user controllers
Route::post('/userRegProcess', [UserController::class, 'register']);
Route::post('/userLogin', [UserController::class, 'login']);
Route::post('/userLogout', [UserController::class, 'logout']);