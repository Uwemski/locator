<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ParishController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ResetPasswordController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get("/", function() {
    return view('index2');
})->name('home');

Route::get('/about', function(){
    return view('about');
})->name('about');

//Route views for Users
Route::middleware(['auth:user'])->group(function(){
    Route::get("/userDashboard", function(){
        return view("user.userDashboard");
    })->name('userDashboard');
});


//guest middleware
Route::middleware('guest')->group(function(){
    Route::get("/userLogin", function(){
        return view("user.userLogin");
    })->name("userLogin");

    Route::get('/reg_test', function(){
        return view('parish.reg_test');
    })->name('reg_test');

    Route::get('/parish_login', function(){
        return view('parish.parish_login');
    })->name('login');

    //create
    Route::post('/parish_reg', [ParishController::class, 'register']);
    //login
    Route::post('/parish_login', [ParishController::class, 'login']);
});

Route::get("/userReg", function(){
    return view('user.userReg');
})->name('userReg');



//this route uses openstreetmap

//middleware for parish
Route::middleware(['auth:parish'])->group(function() {
    Route::get('/parish_dashboard', function () {
        return view('parish.parish_dashboard');
    })->name('parish_dashboard');

    // Route::get('/parish/update_profile', function(){
    //     return view('parish.update_profile');
    // })->name('update_profile');

    Route::get('/parish/update_profile/index', [ParishController::class, 'updateProfileIndex'])->name('update_profile_index');
    
    Route::get('/parish/manage_location', function(){
        return view('parish.manage_location');
    })->name('manage_location');

    //update
    Route::put('/parish/manage_location', [ParishController::class, 'manage_location']);
    Route::put('/parish/update_profile', [ParishController::class,  'update_self']);

    //Route::get('/parish_dashboard', [ParishController::class, 'index'])->name('parish.profile');
    Route::get('/parish_dashboard', [ParishController::class, 'index'])->name('parish_dashboard');

    Route::get('/parish/service', function(){
        return view('parish.service');
    } )->name('service.create.index');
    //create
    Route::post('/parish/create_service', [ServicesController::class, 'create'])->name('services.create');
    //view
    Route::get('/service/show', [ServicesController::class, 'show'])->name('service.show');
    //delete
    Route::delete('/service/delete/{service}', [ServicesController::class, 'delete'])->name('service.delete');


    Route::get('/event', [EventController::class, 'view_events_for_parish'])->name('event.show');
    Route::post('/events/create', [EventController::class, 'create'])->name('event.create');
    Route::get('parish/event/{id}/edit', [EventController::class, 'edit'])->name('events.edit');

    Route::put('parish/event/{id}/update', [EventController::class, 'update'])->name('events.update');
    //Route::patch('/event/{id}', [EventController::class, 'update']);
    Route::delete('parish/event/delete/{event}', [ParishController::class, 'delete'])->name('event.remove');
});

//routes for admin
Route::get('/admin/login', function(){
    return view('admin.admin_login');
})->name('admin_login');

//Middlewares for admin
Route::middleware(['auth:admin'])->group(function(){
    
    Route::get('/admin/viewUsers', [AdminController::class, 'viewAllUsers'])->name('admin.all_users');
    Route::get('/admin/viewParishes', [AdminController::class, 'viewAllParishes'])->name('admin.all_parish');
    Route::get('/admin/active', [AdminController::class, 'showActiveParishes'])->name('admin.active_parish');
    Route::get('/admin/unverified', [AdminController::class, 'showUnverifiedParishes'])->name('admin.unverified');
    Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');
    Route::post('/admin/create_admin', [AdminController::class, 'register']);
    Route::delete('/parishes/{parish}', [AdminController::class, 'parish_destroy'])->name('parish.destroy');
    Route::put('/admin/{parish}', [AdminController::class, 'update'])->name('parish.update');
    Route::get('/admin/create_admin', function(){
        return view('admin.create_admin');
    })->name('admin_create');
    Route::post('/adminLogout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
    Route::get('admin/suspended_parish', [AdminController::class, 'showSuspendedParish'])->name('admin.suspended');
    //controller method for number of parishes
    Route::get('/adminDashboard', [AdminController::class, 'numberOfParishesUsers'])->name('adminDashboard');
    //number of users
    //Route::get('/adminDashboard', [AdminController::class, 'numberOfUsers'])->name('users.count');
});

//this Route should not be in middleware because visitors are gonna use it
Route::get('/map/parish', [AdminController::class, 'showVerifiedParishes'])->name('superPower');

//admin controllers
Route::post('/admin/login', [AdminController::class, 'login']);



//user controllers
Route::post('/userRegProcess', [UserController::class, 'register']);
Route::post('/userLogin', [UserController::class, 'login']);
Route::post('/userLogout', [UserController::class, 'logout']);

//Parish Controllers

Route::post('/parish/logout', [ParishController::class, 'logout']);

Route::get('visitor/search', [ParishController::class, 'searchForVisitors'])->name('find.parish');

Route::get('/nearest-parish', [AdminController::class, 'getNearest']);

//test
Route::get('testing-api', function(){
    return view('testApi');
})->name('testing-api');

Route::get('/debug-log', function () {
     try {
        \Log::info('Laravel is running');
        return 'Laravel booted successfully.';
    } catch (\Throwable $e) {
        return 'Laravel crashed during boot: ' . $e->getMessage();
    }
});

//routes for events
Route::get('/events', function(){
    return view('parish.events');
})->name('events');

// this is for sitevisitor 
Route::get('/event/parish/{id}', [EventController::class, 'visitor_search_event'])->name('event.find');

Route::get('/admin/parish/{id}', [ServicesController::class, 'find_service_by_parish'])->name('service.find');
//view_events_for_parish

//routes for loaction controller
Route::get('/locations/states', [LocationController::class, 'getStates']);
Route::get('/locations/lgas/{state}', [LocationController::class, 'getLgas']);

//routes to reset password
Route::get('/forget-password', [ResetPasswordController::class, 'index'])->name('auth.forget-password.index');

// routes/web.php (temporary)
Route::get('/debug-json', function () {
    $response = \Illuminate\Support\Facades\Http::get(
        "https://temikeezy.github.io/nigeria-geojson-data/data/full.json"
    );
    return response()->json(collect($response->json())->take(2)); // show first 2 items
});




Route::post('/forget-password', [ResetPasswordController::class, 'forgetPassword'])->name('auth.forget-password');
Route::get('/reset-password', [ResetPasswordController::class, 'resetPasswordIndex'])->name('auth.reset-password.index');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('auth.reset-password');
