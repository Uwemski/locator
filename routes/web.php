<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::post("/userRegProcess", [UserController::class, 'register']);