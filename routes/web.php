<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\FriendshipController;

// Statiskas lapas
Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/forum', function () {
    return view('pages.forum.index');
})->name('forum.index');

Route::get('/collections', function () {
    return view('pages.collections.index');
})->name('collections.index');

// Reģistrācija un autorizācija
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Dinamiskie maršruti visiem lietotājiem
Route::get('/collections/popular', [CollectionController::class, 'popular'])->name('collections.popular'); // Популярные коллекции
Route::get('/media/{id}', [MediaController::class, 'show'])->name('media.show'); // Детальная информация о медиа

// Paredzēts autorizētiem lietotājiem
Route::middleware(['auth'])->group(function () {
    // Lietotāju profils
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');

    // Kolekciju pārvaldība
    Route::get('/collections/my', [CollectionController::class, 'myCollections'])->name('collections.my');
    Route::post('/collections', [CollectionController::class, 'store'])->name('collections.store');
    Route::post('/collections/{id}', [CollectionController::class, 'update'])->name('collections.update');
    Route::delete('/collections/{id}', [CollectionController::class, 'destroy'])->name('collections.destroy');

    // Forums
    Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
    Route::post('/forum/{id}/comment', [ForumController::class, 'comment'])->name('forum.comment');

    // Draudzība
    Route::post('/friendships', [FriendshipController::class, 'sendRequest'])->name('friendships.send');
    Route::post('/friendships/{id}/accept', [FriendshipController::class, 'acceptRequest'])->name('friendships.accept');
    Route::delete('/friendships/{id}', [FriendshipController::class, 'destroy'])->name('friendships.destroy');

    // Vērtējumi un mijiedarbība ar multividi
    Route::post('/media/{id}/rate', [MediaController::class, 'rate'])->name('media.rate');
});

// Administrators
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [UserController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::delete('/forum/{id}', [ForumController::class, 'destroy'])->name('forum.destroy');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{id}/privileges', [UserController::class, 'changePrivileges'])->name('users.privileges');
});
