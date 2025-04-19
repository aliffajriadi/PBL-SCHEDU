<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
Route::get('/login', function () {
    return view('login');
});

// teachStudent view
Route::get('/dashboard', function () {
    return view('teachStudent.dashboard');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/test', function () {
    return view('teachStudent.test');
});
Route::get('/notes', function () {
    return view('teachStudent.notes');
});


Route::prefix('/notes')->group(function () {
    Route::get('/', function () {
        return view('teachStudent.notes');
    });
    Route::get('/detail', function () {
        return view('teachStudent.notes-detail');
    });
});


Route::get('/task', function () {
    return view('teachStudent.task');
});
Route::get('/profile', function () {
    return view('profile');
});
Route::get('/schedule', function () {
    return view('teachStudent.schedule');
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

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });
    Route::get('/instatiate', function () {
        return view('admin.instatiate');
    });
    Route::get('/staff', function () {
        return view('admin.staff');
    });
});

//STAFF ROUTE DUMMY
Route::prefix('/staff')->group( function () {
    Route::get('/dashboard', function () {
        return view('staff.dashboard');
    });
    Route::get('/account', function () {
        return view('staff.account');
    });
    Route::get('/group', function () {
        return view('staff.group');
    });
});








