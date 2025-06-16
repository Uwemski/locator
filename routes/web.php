<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ParishController;
 

Route::get('/', function () {
    return view('welcome');
});

Route::get("/home", function(){
    return view('index');
})->name("homepage");

Route::get('/about', function(){
    return view('about');
})->name('about');

//Route views for Users
Route::get("/userReg", function(){
    return view('user.userReg');
})->name('userReg');

Route::get("/userLogin", function(){
    return view("user.userLogin");
})->name("userLogin");

Route::get("/userDashboard", function(){
    return view("user.userDashboard");
})->name('userDashboard');

Route::get('/test', function(){
    return view('user.test');
})->name('Testing');

//ROUTES FOR PARISH

//this is the file that intended to use googlemaps API
// Route::get('/parish_reg', function(){
//     return view('parish.parish_reg');
// })->name('parish_reg'); since there is an invalid map key, let's comment it out

//this route uses openstreetmap
Route::get('/reg_test', function(){
    return view('parish.reg_test');
})->name('reg_test');

Route::get('/parish_login', function(){
    return view('parish.parish_login');
})->name('login');


Route::middleware(['auth:parish'])->group(function() {
    Route::get('/parish_dashboard', function () {
        return view('parish.parish_dashboard');
    })->name('parish_dashboard');

    Route::get('/parish/update_profile', function(){
        return view('parish.update_profile');
    })->name('update_profile');
    
    Route::get('/parish/manage_location', function(){
        return view('parish.manage_location');
    })->name('manage_location');


    Route::put('/parish/manage_location', [ParishController::class, 'manage_location']);
    Route::put('/parish/update_profile', [ParishController::class,  'update_self']);

    //Route::get('/parish_dashboard', [ParishController::class, 'index'])->name('parish.profile');
    Route::get('/parish_dashboard', [ParishController::class, 'index'])->name('parish_dashboard');

});

// Route::middleware(['auth:parish'])->group(function () {
//     Route::get('/parish_dashboard', function () {
//         return view('parish.parish_dashboard');
//     })->name('parish_dashboard');
// });



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

//Middlewares for admin
Route::middleware(['auth:admin'])->group(function(){
    Route::get('/adminDashboard', function(){
        return view("admin.admin_dashboard");
    })->name("adminDashboard");

    // Route::get('/admin/viewUsers', function(){
    //     return view('admin.all_users');
    // })->name('allUsers');
    Route::get('/admin/viewUsers', [AdminController::class, 'viewAllUsers'])->name('admin.all_users');

    // Route::get('/admin/viewParishes', function(){
    //     return view('admin.all_parish');
    // })->name('allParishes');

    Route::get('/admin/viewParishes', [AdminController::class, 'viewAllParishes'])->name('admin.all_parish');
});

//admin controllers
Route::post('/admin/login', [AdminController::class, 'login']);

Route::post('/admin/create_admin', [AdminController::class, 'register']);

Route::post('/adminLogout', [AdminController::class, 'logout']);

Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');

Route::delete('/parishes/{parish}', [AdminController::class, 'parish_destroy'])->name('parish.destroy');

Route::put('/admin/{parish}', [AdminController::class, 'update'])->name('parish.update');

//user controllers
Route::post('/userRegProcess', [UserController::class, 'register']);
Route::post('/userLogin', [UserController::class, 'login']);
Route::post('/userLogout', [UserController::class, 'logout']);

//Parish Controllers
Route::post('/parish_reg', [ParishController::class, 'register']);

Route::post('/parish_login', [ParishController::class, 'login']);

Route::post('/parish/logout', [ParishController::class, 'logout']);
