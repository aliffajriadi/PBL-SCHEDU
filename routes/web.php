<?php

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\GroupController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\MemberOfController;

use App\Http\Controllers\GroupNoteController;
use App\Http\Controllers\GroupTaskController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PersonalNoteController;
use App\Http\Controllers\PersonalTaskController;
use App\Http\Controllers\GroupScheduleController;
use App\Http\Controllers\GroupTaskUnitController;
use App\Http\Controllers\PersonalScheduleController;
use App\Http\Controllers\GroupTaskSubmissionController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\StaffNotificationController;

Route::get('user-check', [UserController::class, 'user_check']);

Route::get('/', [PublicController::class, 'index']);
Route::get('/login', [PublicController::class, 'login_page']);

Route::get('/login', [PublicController::class, 'login_page']);

Route::post('/login', [PublicController::class, 'login'])->name('login');

// User Routes

Route::middleware('auth:web')->prefix('/')->group(function () {
    Route::post('/logout', [PublicController::class, 'logout']);

    Route::get('/dashboard', [UserController::class, 'home']);

    Route::get('/profile', [UserController::class, 'profile']);

    Route::patch('/profile/update', [UserController::class, 'update_profile']);

    Route::patch('/profile/change_password', [UserController::class, 'change_password']);

    Route::prefix('/note')->group(function () {

        Route::get('/', [PersonalNoteController::class, 'home']);
    
        Route::apiResource('/api', PersonalNoteController::class);
    
    });

    Route::prefix('/task')->group(function() {
        Route::get('/', [PersonalTaskController::class, 'home']);

        Route::patch('/set_finished/{task}', [PersonalTaskController::class, 'set_finish']);

        Route::patch('/reset_finished/{task}', [PersonalTaskController::class, 'reset_finish']);

        Route::patch('/reset_finished/{task}');

        Route::apiResource('/api', PersonalTaskController::class);

        Route::post('/done/{task}', [PersonalTaskController::class, 'set_done']);
    });



    Route::prefix('/schedule')->group(function(){
        Route::get('/', [PersonalScheduleController::class, 'home']);

        Route::apiResource('/api', PersonalScheduleController::class);
    });
    
    Route::prefix('/notification')->group(function () {
    
        Route::get('/', [NotificationController::class, 'home']);
    
        Route::apiResource('/api', NotificationController::class);
    });
    
    
});

Route::get('/test', function () {
    return view('teachStudent.test');
});

Route::middleware('auth:web')->prefix('/group')->group(function () {
    
    Route::apiResource('/api', GroupController::class);

    Route::get('/', [GroupController::class, 'group_list']);

    Route::prefix('/{group:group_code}')->group(function() {
        Route::get('/', [GroupController::class, 'dashboard']);

        Route::prefix('/note')->group(function () {
            Route::get('/', [GroupNoteController::class, 'home']);
            Route::apiResource('/api', GroupNoteController::class);
            Route::get('/file/{stored_name}', [GroupNoteController::class, 'download_file']);
            Route::delete('/file/{taskFileSubmission:stored_name}', [GroupNoteController::class, 'delete_file']);
            Route::patch('/file/{note}', [GroupNoteController::class, 'upload_file']);
        });

        Route::prefix('/schedule')->group(function () {
            Route::get('/', [GroupScheduleController::class, 'home']);

            Route::apiResource('/api', GroupScheduleController::class);
        });

        Route::prefix('/task')->group(function () {
            Route::get('/', [GroupTaskController::class, 'dashboard']);
            Route::post('/unit', [GroupTaskUnitController::class, 'store']);
            Route::post('/s/{group_task}', [GroupTaskSubmissionController::class, 'store']);
            Route::patch('/s/{submission}', [GroupTaskSubmissionController::class, 'update']);
            Route::delete('/s/{submission}', [GroupTaskSubmissionController::class, 'destroy']);

            Route::get('/file/{stored_name}', [GroupTaskSubmissionController::class, 'download_file']);
            Route::delete('/file/{taskFileSubmission:stored_name}', [GroupTaskSubmissionController::class, 'delete_file']);

            Route::apiResource('/api', GroupTaskController::class);
            // Route::apiResource('/submission', GroupTaskSubmissionController::class);
        });

        Route::prefix('/settings')->group(function () {
            Route::get('/', [MemberOfController::class, 'index']);
           
            Route::post('/approve/{member_of}', [MemberOfController::class, 'verifying']);
        
            Route::delete('/out/{member_of}', [MemberOfController::class, 'leave_group']);

            Route::delete('/delete', [GroupController::class, 'destroy']);

            Route::delete('delete_all/{table}', [MemberOfController::class, 'delete_all']);
        });

    });

    Route::post('join_group', [MemberOfController::class, 'join_group']);

});

//===============================================================================================
//ADMIN ROUTE

// ROUTE FOR ADMIN NON MIDDLEWARE / FOR PUBLIC GUEST
Route::controller(AdminController::class)->group(function () {
    Route::post('/admin/login', 'login');
    Route::get('/admin/logout', 'logout');
    Route::get('/admin/login', 'view_login');
});

// ROUTE ADMIN WITH MIDDLEWARE
Route::prefix('/admin')->middleware('admin')->controller(AdminController::class)->group(function () {
    Route::get('/dashboard', 'index');
    Route::post('/password', 'edit_password');
    Route::post('/username', 'edit_username');
    Route::get('/profile', 'profile')->name('profile-admin');
    Route::get('/instatiate', 'instatiate')->name('instantiate_manage');
});

Route::prefix('/admin')->middleware('admin')->controller(StaffController::class)->group(function(){
    Route::post('/instantiate-store', 'store')->name('store-instantiate');
    Route::delete('/staffs/{staff}', 'destroy');
});


//END ADMIN ROUTE
//===============================================================================================



//===============================================================================================
//STAFF ROUTE


//STAFF NON MIDDLEWARE / FOR PUBLIC GUEST
Route::get('/staff/login', [StaffController::class, 'view_login']);
Route::post('/staff/login', [StaffController::class, 'login']);

//ROUTE FOR WITH MIDDLEWARE STAFF
Route::prefix('/staff')->middleware('staff')->group(function () {
    Route::controller(StaffController::class)->group(function(){
        Route::get('/dashboard', 'dashboard');
        Route::get('/group', 'view_group');
        Route::get('/account', 'view_account');
        Route::get('/profile', 'view_profile');
        Route::put('/profile/update', 'update');
        Route::put('/profile/password', 'update_password');
        Route::post('/logout', 'logout');
        Route::put('/user/{uuid}', 'update_user');
        Route::put('/userpassword', 'update_password_user');
        Route::delete('/group/destroy/{group}', 'destroy_group');
        
    });
    Route::post('/create-user', [UserController::class, 'store']);
    Route::post('/account/insert-file', [UserController::class, 'insert_file']);
    Route::resource('/user', UserController::class);

    Route::get('/notification', [StaffNotificationController::class, 'home']);

    Route::apiResource('/notifications', StaffNotificationController::class);

});


//END ROUTE FOR STAFF / INSTANSI
//===============================================================================================

