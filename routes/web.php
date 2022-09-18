<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

    return Inertia::render('Users', [
        'users' => User::paginate(10)->through(fn($user) => [
            'id' => $user->id,
            'name' => $user->name
        ])
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
