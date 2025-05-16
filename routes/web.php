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

Route::get("/dashboard", function(){
    return view("user.dashboard");
})->name('dashboard');

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

//admin controllers
Route::post('/admin/login', [AdminController::class, 'login']);

//usr controller
Route::post("/userRegProcess", [UserController::class, 'register']);