<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\ContestController;

use App\Http\Controllers\PlaceController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::put('/places/{id}', [PlaceController::class, 'update'])->name('update.place');

Route::post('store/character', [PlaceController::class, 'store'])->name('store.place');


Route::get('create/character', [PlaceController::class, 'create'])->name('create.character');

Route::get('/places/{id}/edit', [PlaceController::class, 'edit'])->name('place.edit');
Route::delete('/places/{id}', [PlaceController::class, 'destroy'])->name('place.destroy');


Route::get('/places', [PlaceController::class, 'index'])->name('place.index');


Route::post('/contest/attack', [ContestController::class, 'processAction'])->name('contest.attack');

Route::get('/contests/webpage', function () {
    return view('webpages.contest');
})->name('contest');

Route::post('/contests/generate', [ContestController::class, 'generate'])->name('contest.generate');


Route::delete('/characters/{id}', [CharacterController::class, 'destroy'])->name('characters.destroy');

Route::get('/characters/{id}/edit', [CharacterController::class, 'edit'])->name('characters.edit');

Route::put('/characters/{id}', [CharacterController::class, 'update'])->name('characters.update');


Route::get('/characters/response', function () {
    return view('webpages.response');
})->name('response');

Route::get('/characters/create', [CharacterController::class, 'create'])->name('character.create');
Route::post('/characters', [CharacterController::class, 'store'])->name('character.store');



Route::get('/characters/toCreateForm', [CharacterController::class, 'toCreateForm'])->name('character.toCreateForm');

Route::get('/character/{id}', [CharacterController::class, 'show'])->name('character.detail');



Route::get('/login', function () {
    return view('webpages.login');
})->name('login');


Route::get('/userdata', function () {
    return view('webpages.userdata');
})->name('userdata');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('webpages.userdata');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
