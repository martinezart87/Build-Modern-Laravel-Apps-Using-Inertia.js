<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('login', [LoginController::class, 'create'])->name('login');
Route::post('login', [LoginController::class, 'store']);
Route::post('logout', [LoginController::class, 'destroy'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Home');
    });

    Route::get('/users', function () {
        // return UserResource::collection(User::all());
        // return User::all();

        // Z użyciem api resource
        return Inertia::render('Users/Index', [
            'users' => UserResource::collection(User::query()->paginate(20)->withQueryString()),
            'filters' => Request::only(['search']),
            'can' => [
                'createUser' => Auth::user()->can('create', User::class)
            ]
        ]);


        return Inertia::render('Users/Index', [
            'users' => User::query()
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->paginate(10)
                ->withQueryString()
                ->through(fn($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'can' => [
                        'edit' => Auth::user()->can('edit', $user)
                    ]
                ]),

            'filters' => Request::only(['search']),
            'can' => [
                'createUser' => Auth::user()->can('create', User::class)
            ]
        ]);
    });

    Route::get('/users/create', function () {
        return Inertia::render('Users/Create');
    })->can('create', 'App\Models\User');

    Route::post('/users', function () {
        $attributes = Request::validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        User::create($attributes);

        return redirect('/users');
    });

    Route::get('/users/{id}/edit', [LoginController::class, 'edit'])->can('edit', 'App\Models\User');
    Route::put('/users/update', [LoginController::class, 'update'])->can('edit', 'App\Models\User');

    Route::get('/users/{id}/show', function() {
        // nalezy dodać tablicę data do zmiennych we vue lub AppServcieProvider dodać JsonResource::withoutWrapping();
        return Inertia::render('Users/Edit');
    });

    Route::get('/settings', function () {
        return Inertia::render('Settings');
    });
});

// Route::get('/users/create', function () {
//     return Inertia::render('Users/Create');
// });

// Route::post('/users', function () {
//     $attributes = Request::validate([
//         'name' => 'required',
//         'email' => ['required', 'email'],
//         'password' => 'required',
//     ]);

//     User::create($attributes);

//     return redirect('/users');
// });
