<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PersonalNoteController;

use App\Http\Controllers\GroupController;
use App\Http\Controllers\MemberOfController;
use App\Http\Controllers\NotificationController;

use App\Http\Controllers\GroupNoteController;
use App\Http\Controllers\GroupScheduleController;
use App\Http\Controllers\GroupTaskController;
use App\Http\Controllers\GroupTaskUnitController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


Route::get('user-check', [UserController::class, 'user_check']);

Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);

// User Routes

Route::get('/dashboard', function () {
    $user = Auth::user();
    $user_data = [$user->name, $user->email];

    return view('teachStudent.dashboard', [
        'user' => $user_data
    ]);
});


// Route::prefix('/user')->group(function() {
//     Route::apiResource('api', UserController::class);
// });

// // teachStudent view

Route::get('/test', function () {
    return view('teachStudent.test');
});

Route::get('/profile', [UserController::class, 'profile']);

Route::prefix('/note')->group(function () {

    Route::get('/', function () {
        $user = Auth::user();
        $user_data = [$user->name, $user->email];
        return view('teachStudent.notes-detail', [
            'user' => $user_data
        ]);
    });

    Route::apiResource('/api', PersonalNoteController::class);

});

Route::apiResource('/user', UserController::class);


Route::get('/task', function () {
    $user = Auth::user();
    $user_data = [$user->name, $user->email];

    return view('teachStudent.task', [
        'user' => $user_data

    ]);
});

Route::get('/schedule', function () {
    $user = Auth::user();
    $user_data = [$user->name, $user->email];

    return view('teachStudent.schedule', [
        'user' => $user_data
    ]);
});

Route::prefix('/notification')->group(function () {

    Route::get('/', function () {
        $user = Auth::user();
        $user_data = [$user->name, $user->email];

        return view('notification', [
            'user' => $user_data
        ]);
    });

    Route::apiResource('/api', NotificationController::class);
});


Route::prefix('/group')->group(function () {
    
    Route::apiResource('/api', GroupController::class);

    Route::get('/', function () {
        $role = session('role');
        $user = Auth::user();
        $user_data = [
            $user->name, $user->email
        ];
    
        return view('group.group-list', [
            'role' => $role, 
            'user' => $user_data,
            'folder_name' => Auth::user()->instance->folder_name
        ]);
    });

    Route::prefix('/{group:group_code}')->group(function() {
        Route::get('/', [GroupController::class, 'dashboard']);

        Route::prefix('/note')->group(function () {
            Route::get('/', function () {
                $role = session('role');
                $user = Auth::user();
                $user_data = [
                    $user->name, $user->email
                ];
            
                return view('group.group-notes', [
                    'role' => $role, 
                    'user' => $user_data
                ]);
            });
            Route::apiResource('/api', GroupNoteController::class);
        });

        Route::prefix('/schedule')->group(function () {
            Route::get('/', function () {
                $role = session('role');
                $user = Auth::user();
                $user_data = [
                    $user->name, $user->email
                ];
            
                return view('group.group-schedule', [
                    'role' => $role, 
                    'user' => $user_data
                ]);
            });

            Route::apiResource('/api', GroupScheduleController::class);
        });

        Route::prefix('/task')->group(function () {
            Route::get('/', [GroupTaskController::class, 'dashboard']);
            Route::post('/unit', [GroupTaskUnitController::class, 'store']);

            Route::apiResource('/api', GroupTaskController::class);
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

// Route::get('/group/detail/dashboard', function () {
//     return view('group.group-dashboard');
// } );
// Route::get('/group/detail/notes', function () {
//     return view('group.group-notes');
// } );
// Route::get('/group/detail/task', function () {
//     return view('group.group-task');
// } );
// Route::get('/group/detail/schedule', function () {
//     return view('group.group-schedule');
// } );
// Route::get('/group/detail/settings', function () {
//     return view('group.group-settings');
// } );



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
        
    });
    Route::post('/create-user', [UserController::class, 'store']);
    Route::post('/account/insert-file', [UserController::class, 'insert_file']);
    Route::resource('/user', UserController::class);
});


//END ROUTE FOR STAFF / INSTANSI
//===============================================================================================

