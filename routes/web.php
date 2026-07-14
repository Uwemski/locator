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

    Route::get('/parish/register', function(){
        return view('parish.reg-test');
    })->name('parish.register');

    Route::get('/parish/login', function(){
        return view('parish.parish-login');
    })->name('parish.login');

    //create
    Route::post('/parish/reg', [ParishController::class, 'register'])->name('parish.register.store');
    //login
    Route::post('/parish/login', [ParishController::class, 'login'])->name('parish.login.store');
});

Route::get("/userReg", function(){
    return view('user.userReg');
})->name('userReg');



//this route uses openstreetmap

//middleware for parish
Route::middleware(['auth:parish'])->group(function() {
    Route::get('/parish/update_profile/index', [ParishController::class, 'updateProfileIndex'])->name('parish.update-profile.index');
    
    Route::get('/parish/manage-location', function(){
        return view('parish.manage-location');
    })->name('parish.manage-location');

    //update
    Route::put('/parish/manage-location', [ParishController::class, 'manageLocation']);
    Route::put('/parish/update-profile', [ParishController::class,  'updateSelf'])->name('parish.update.profile');

    //Route::get('/parish_dashboard', [ParishController::class, 'index'])->name('parish.profile');
    Route::get('/parish-dashboard', [ParishController::class, 'index'])->name('parish.dashboard');

    Route::prefix('parish/service')->name('parish.service.')->group(function (){

        Route::get('/', function(){
            return view('parish.service');
        })->name('index');

        //create
        Route::post('/create', [ServicesController::class, 'create'])->name('create');
        //view
        Route::get('/show', [ServicesController::class, 'show'])->name('show');
        //delete
        Route::delete('/delete/{service}', [ServicesController::class, 'delete'])->name('delete');
    });
    // Route::get('/parish/service', function(){
    //         return view('parish.service');
    //     })->name('parish.service.index');

    Route::prefix('parish/events')->name('parish.event.')->group(function () {
        Route::get('/', [EventController::class, 'viewEventsForParish'])->name('show');

        Route::get('/create', function(){
            return view('parish.events');
        })->name('index');

        Route::post('/create', [EventController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [EventController::class, 'edit'])->name('edit');

        Route::put('/{id}/update', [EventController::class, 'update'])->name('update');
        //Route::patch('/event/{id}', [EventController::class, 'update']);
        Route::delete('/{id}/delete', [EventController::class, 'delete'])->name('delete');
    });

    Route::post('/parish/logout', [ParishController::class, 'logout']);
});

//routes for admin
Route::get('/admin/login', function(){
    return view('admin.admin-login');
})->name('admin-login');

//Middlewares for admin
Route::middleware(['auth:admin'])->group(function(){
    
    Route::get('/admin/viewUsers', [AdminController::class, 'viewAllUsers'])->name('admin.users.index');
    Route::get('/admin/viewParishes', [AdminController::class, 'viewAllParishes'])->name('admin.parishes.index');
    Route::get('/admin/active', [AdminController::class, 'showActiveParishes'])->name('admin.parishes.verified');
    Route::get('/admin/unverified', [AdminController::class, 'showUnverifiedParishes'])->name('admin.parishes.unverified');
    Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');
    Route::post('/admin/create/admin', [AdminController::class, 'register']);
    Route::delete('/parishes/{parish}', [AdminController::class, 'parishDestroy'])->name('parish.destroy');
    Route::put('/admin/{parish}', [AdminController::class, 'update'])->name('admin.parish.update');
    Route::get('/admin/create-admin', function(){
        return view('admin.create-admin');
    })->name('admin-create');
    Route::post('/adminLogout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
    Route::get('admin/suspended-parish', [AdminController::class, 'showSuspendedParish'])->name('admin.parishes.suspended');
    //controller method for number of parishes
    Route::get('/adminDashboard', [AdminController::class, 'numberOfParishesUsers'])->name('adminDashboard');

    Route::get('/admin/parish/{id}', [ServicesController::class, 'findServiceByParish'])->name('service.find');

});

//this Route should not be in middleware because visitors are gonna use it
Route::get('/map/parish', [AdminController::class, 'showVerifiedParishes'])->name('superPower');

//admin controllers
Route::post('/admin/login', [AdminController::class, 'login']);



//user controllers
Route::post('/userRegProcess', [UserController::class, 'register']);
Route::post('/userLogin', [UserController::class, 'login']);
Route::post('/userLogout', [UserController::class, 'logout']);


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

// this is for sitevisitor 
Route::get('/event/parish/{id}', [EventController::class, 'visitorSearchEvent'])->name('event.find');



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



//this should be for guest parishes and also in the dashboard of the parish
Route::post('/forget-password', [ResetPasswordController::class, 'forgetPassword'])->name('auth.forget-password');
Route::get('/reset-password', [ResetPasswordController::class, 'resetPasswordIndex'])->name('auth.reset-password.index');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('auth.reset-password');
