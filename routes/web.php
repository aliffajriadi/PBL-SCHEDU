<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
Route::get('/login', function () {
    return view('login');
});

// student view
Route::get('/dashboard', function () {
    return view('student.dashboard');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/test', function () {
    return view('student.test');
});
Route::get('/notes', function () {
    return view('student.notes');
});


Route::prefix('/notes')->group(function () {
    Route::get('/', function () {
        return view('student.notes');
    });
    Route::get('/detail', function () {
        return view('student.notes-detail');
    });
});


Route::get('/profile', function () {
    $user = [
        ['name' => 'John Doe', 'email' => 'kuntul'],
        ['name' => 'John Doe', 'email' => 'kuntul'],
        ['name' => 'John Doe', 'email' => 'kuntul'],
        ['name' => 'John Doe', 'email' => 'kuntul'],
        ['name' => 'John Doe', 'email' => 'kuntul']
    ];
    return response()->json($user);
});

Route::get('/task', function () {
    return view('student.task');
});
Route::get('/profile', function () {
    return view('profile');
});
Route::get('/schedule', function () {
    return view('student.schedule');
});
Route::get('/notification', function () {
    return view('notification');
});

Route::get('/group', function () {
    $role = 'teacher';
    return view('group.group-list', compact('role'));
});

Route::get('/group/detail/dashboard', function () {
    return view('group.group-dashboard');
} );
Route::get('/group/detail/notes', function () {
    return view('group.group-notes');
} );
Route::get('/group/detail/task', function () {
    return view('group.group-task');
} );
Route::get('/group/detail/schedule', function () {
    return view('group.group-schedule');
} );
Route::get('/group/detail/settings', function () {
    return view('group.group-settings');
} );


//admin route dummy

Route::get('/dashboard/admin', function () {
    return view('admin.dashboard-admin');
} );








