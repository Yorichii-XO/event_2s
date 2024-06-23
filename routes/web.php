<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

// Define Clerk authentication routes
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


Route::get('/', [HomeController::class, 'index']);
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

// Logout Route
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

##############evnets


Route::resource('events', EventController::class);
Route::get('events/{event}/comments', [EventController::class, 'showComments'])->name('events.comments');
Route::delete('events/{event}', [EventController::class, 'destroy'])->name('events.delete');
Route::post('events/{event}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/events/{eventId}/comments', 'CommentController@getComments')->name('comments.get');



Route::post('/events/{event}/rate', [EventController::class, 'rate'])->name('events.rate');
Route::post('/events/{event}/register', [EventController::class, 'register'])->name('events.register');
Route::delete('/events/{event}/unregister',[EventController::class, 'unregister'])->name('events.unregister');
Route::get('/events/{event}/comments', [EventController::class, 'comments'])->name('events.comments');
Route::delete('/comments/{commentId}', [CommentController::class, 'deleteComment'])->name('comments.delete');
Route::get('/users', [UserController::class, 'index'])->name('users.index');

// Show the form for creating a new resource.
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

// Store a newly created resource in storage.
Route::post('/users', [UserController::class, 'store'])->name('users.store');

// Show the form for editing the specified resource.
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

// Update the specified resource in storage.
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

// Remove the specified resource from storage.
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');