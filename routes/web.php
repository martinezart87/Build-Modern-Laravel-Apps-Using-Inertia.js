<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/users', function () {
    // First definiton
    // sleep(2);
    // return Inertia::render('Users',[
    //     'time' => now()->toTimeString()
    // ]);


    // Episode 16
    // return Inertia::render('Users', [
    //     // User:all() = przesyła cały obiekt userów do klietna. w dodatku Vue -> Laytot -> tablica users
    //     'users' => User::all()->map(fn($user) => [
    //         'name' => $user->name
    //     ])
    // ]);

    // Episode 17 - paginate through = map, ale przy paginate stosuje się through
    // return Inertia::render('Users', [
    //     'users' => User::paginate(10)->through(fn($user) => [
    //         'id' => $user->id,
    //         'name' => $user->name
    //     ])
    // ]);

    // Episode 18 
    return Inertia::render('Users', [
        'users' => User::query()
            ->when(Request::input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(10)
            // dodaje query string do linku
            ->withQueryString()
            ->through(fn($user) => [
                'id' => $user->id,
                'name' => $user->name
            ]),
        
        // dodanie propsa
        'filters' => Request::only(['search'])
    ]);
});

Route::get('/settings', function () {
    return Inertia::render('Settings');
});

Route::post('/logout', function () {
    dd(request('foo'));
});

Route::get('/welcome', function () {
    // Fasada lub helper - to samo
    // drugi argument - props
    // nazwa musi być taka sama jak nazwa pliku w kat. Pages
    return Inertia::render('Welcome', [
        'name' => 'Marcin',
        'surname' => 'Świerczek',
        'frameworks' => [
            'Laravel', 'Vue', 'Inertia'
        ]
    ]);
    // return inertia('Welcome');
});
