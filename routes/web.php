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
use App\Http\Controllers\GroupTaskSubmissionController;
use App\Http\Controllers\GroupTaskUnitController;
use App\Http\Controllers\PersonalScheduleController;
use App\Http\Controllers\PersonalTaskController;
use App\Models\PersonalTask;
use Illuminate\Support\Facades\Auth;


Route::get('user-check', [UserController::class, 'user_check']);

Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', [UserController::class, 'login'])->name('login');

// User Routes
Route::post('/submit-task/{group_task}', [GroupTaskSubmissionController::class, 'create']);

Route::middleware('auth:web')->prefix('/')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);

    Route::get('/dashboard', function () {
        $user = Auth::user();
        $user_data = [$user->name, $user->email];
    
        return view('teachStudent.dashboard', [
            'user' => $user_data
        ]);
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

    Route::prefix('/task')->group(function() {
        Route::get('/', function () {
            $user = Auth::user();
            $user_data = [$user->name, $user->email];

            return view('teachStudent.task', [
                'user' => $user_data

            ]);
        });

        Route::apiResource('/api', PersonalTaskController::class);

    });

    Route::prefix('/schedule')->group(function(){
        Route::get('/', function () {
            $user = Auth::user();
            $user_data = [$user->name, $user->email];
        
            return view('teachStudent.schedule', [
                'user' => $user_data
            ]);
        });

        Route::apiResource('/api', PersonalScheduleController::class);
    });
    
    Route::prefix('/notification')->group(function () {
    
        Route::get('/', function () {
            $user = Auth::user();
            $user_data = [$user->name, $user->email];
    
            return view('notification', [
                'user' => $user_data,
                'role' => $user->is_teacher ? 'teacher' : 'student'
            ]);
        });
    
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


// //admin route dummy

Route::get('/adm_login', function(){
    return view('admin.login');
})->name('admin.login');

Route::post('/admin/login', [AdminController::class, 'login']);

Route::prefix('/admin')->middleware('admin')->group(function () {

    Route::apiResource('/staffs', StaffController::class);

    Route::get('/logout', [AdminController::class, 'logout']);

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



Route::get('/staff/login', function () {
    return view('staff.login');
});

Route::post('/staff/login', [StaffController::class, 'login']);

// //STAFF ROUTE DUMMY
Route::middleware('auth:staff')->prefix('/staff')->group(function () {
    // Route::apiResource('/api', StaffController::class);

    Route::apiResource('/user', UserController::class);


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
