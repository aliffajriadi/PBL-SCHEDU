<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PersonalNoteController;
use App\Http\Controllers\GroupController;


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
    Route::get('/', [PersonalNoteController::class, 'home']);

    Route::get('/detail', function () {
        $user = Auth::user();
        $user_data = [$user->name, $user->email];
        return view('teachStudent.notes-detail', [
            'user' => $user_data
        ]);
    });

    Route::apiResource('/api', PersonalNoteController::class);

});

Route::apiResource('/user', UserController::class);


// Route::get('/notes', function () {
//     return view('teachStudent.notes');
// });

// Route::prefix('/notes')->group(function () {
//     Route::get('/', function () {
//         return view('teachStudent.notes');
//     });

// });


// Route::get('/task', function () {
//     return view('teachStudent.task');
// });
// Route::get('/schedule', function () {
//     return view('teachStudent.schedule');
// });
// Route::get('/notification', function () {
//     return view('notification');
// });

Route::get('/groups', function () {
    $role = session('role');
    $user = Auth::user();
    $user_data = [
        $user->name, $user->email
    ];

    return view('group.group-list', [
        'role' => $role, 
        'user' => $user_data
    ]);
});

Route::prefix('/group')->group(function () {
    Route::apiResource('/api', GroupController::class);

    Route::get('/', [GroupController::class, 'show']);

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
        $user = Auth::user();
        return view('admin.instatiate', [
            'name' => $user->name,
            'email' => $user->email,
            'user' => $user
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
