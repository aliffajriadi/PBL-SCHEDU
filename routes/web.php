<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PersonalNoteController;

use App\Http\Controllers\GroupController;
use App\Http\Controllers\MemberOfController;

use App\Http\Controllers\GroupNoteController;
use App\Http\Controllers\GroupScheduleController;
use App\Http\Controllers\GroupTaskController;
use App\Http\Controllers\GroupTaskUnitController;

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

Route::get('/notification', function () {
    $user = Auth::user();
    $user_data = [$user->name, $user->email];

    return view('notification', [
        'user' => $user_data
    ]);
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




// //admin route dummy

Route::prefix('/admin')->group(function () {
    Route::get('/login', function(){
        return view('admin.login');
    });

    Route::apiResource('/staffs', StaffController::class);

    Route::get('/logout', [AdminController::class, 'logout']);

    Route::post('/login', [AdminController::class, 'login']);

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::get('/instatiate', function () {
        $user = Auth::guard('admin')->user();
        $user_data = [
            $user->username, 'admin'
        ];
        return view('admin.instatiate', [
            'user' => $user_data
        ]);
    });
    
    Route::get('/staff', function () {
        return view('admin.staff');
    });
});


// //STAFF ROUTE DUMMY
Route::prefix('/staff')->group(function () {
    // Route::apiResource('/api', StaffController::class);

    Route::apiResource('/user', UserController::class);

    Route::get('/login', function () {
        return view('staff.login');
    });

    Route::post('/login', [StaffController::class, 'login']);

    Route::post('/logout', [StaffController::class, 'logout']);

    Route::post('/create-user', [UserController::class, 'store']);

    Route::get('/dashboard', function () {
        $user = Auth::guard('staff')->user();
        $data_user = [$user->username, $user->instance_name];
        return view('staff.dashboard', [
            'user' => $data_user
        ]);
    });

    Route::get('/account', function () {
        $user = Auth::guard('staff')->user();
        
        return view('staff.account', [
            'user' => $user
        ]);
    });

    Route::get('/group', function () {
        $user = Auth::guard('staff')->user();
        
        return view('staff.group', [
            'user' => $user
        ]);
    });



});
