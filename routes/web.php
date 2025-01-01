<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\FriendshipController;

// Galvenās lapas maršruts
Route::get('/', function () {
    return view('pages.home'); // Sākumlapas skats
})->name('home');

// Reģistrācija un autorizācija
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register'); // Reģistrācijas formas parādīšana
Route::post('/register', [AuthController::class, 'register']); // Reģistrācijas pieprasījuma apstrāde
Route::get('/profile/complete-registration', [UserController::class, 'showCompleteRegistrationForm'])->middleware('auth')->name('profile.complete_registration_form');// Parāda reģistrācijas pabeigšanas formu
Route::post('/profile/complete-registration', [UserController::class, 'completeRegistration'])->middleware('auth')->name('profile.complete_registration');// Apstrādā reģistrācijas pabeigšanu
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); // Pieteikšanās formas parādīšana
Route::post('/login', [AuthController::class, 'login'])->name('login.post'); // Pieteikšanās pieprasījuma apstrāde
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Izrakstīšanās pieprasījuma apstrāde

// Publiskās sadaļas
Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index'); // Publiskās kolekcijas
Route::get('/collections/popular', [CollectionController::class, 'popular'])->name('collections.popular'); // Populārās kolekcijas

// Foruma sadaļa
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index'); // Foruma sākumlapa
Route::get('/forum/create', [ForumController::class, 'create'])->middleware('auth')->name('forum.create'); // Jauna ieraksta izveidošana
Route::post('/forum', [ForumController::class, 'store'])->middleware('auth')->name('forum.store'); // Ieraksta saglabāšana
Route::get('/forum/search', [ForumController::class, 'search'])->name('forum.search'); // Maršruts, lai meklētu ierakstus pēc atslēgvārdiem
Route::get('/forum/{id}', [ForumController::class, 'show'])->name('forum.show'); // Ieraksta skatīšana
Route::get('/forum/{id}/edit', [ForumController::class, 'edit'])->middleware('auth')->name('forum.edit'); // Ieraksta rediģēšana
Route::put('/forum/{id}', [ForumController::class, 'update'])->middleware('auth')->name('forum.update'); // Ieraksta atjaunināšana
Route::delete('/forum/{id}', [ForumController::class, 'destroyPost'])->name('forum.destroy'); // Ieraksta dzēšana

// Komentāru apstrāde forumā
Route::post('/forum/{id}/comment', [ForumController::class, 'comment'])->middleware('auth')->name('forum.comment'); // Komentāra pievienošana
Route::get('/forum/{postId}/comments/{commentId}/edit', [ForumController::class, 'editComment'])->middleware('auth')->name('forum.comment.edit'); // Komentāra rediģēšanas formas parādīšana
Route::put('/forum/{postId}/comments/{commentId}', [ForumController::class, 'updateComment'])->middleware('auth')->name('forum.comment.update'); // Komentāra atjaunināšana
Route::delete('/forum/{postId}/comments/{commentId}', [ForumController::class, 'destroyComment'])->middleware('auth')->name('forum.comment.destroy'); // Komentāra dzēšana

// Mediju sadaļa
Route::get('/media', [MediaController::class, 'index'])->name('media.index'); // Mediju saraksts
Route::get('/media/create', [MediaController::class, 'create'])->name('media.create'); // Pievienot multivides lapu
Route::get('/media/{id}', [MediaController::class, 'show'])->name('media.show'); // Mediju detaļas
Route::post('/media', [MediaController::class, 'store'])->name('media.store'); // Pievienošanas veidlapas apstrāde
Route::get('/media/{id}/edit', [MediaController::class, 'edit'])->name('media.edit'); // Mediju rediģēšana
Route::post('/media/{id}/update', [MediaController::class, 'update'])->name('media.update'); // Mediju atjaunināšana
Route::delete('/media/{id}', [MediaController::class, 'destroy'])->name('media.destroy'); // Mediju dzēšana

// Lietotāju profilu sadaļa
Route::get('/profile', [UserController::class, 'profile'])->middleware('auth')->name('profile'); // Lietotāja profils
Route::get('/profile/edit', [UserController::class, 'edit'])->middleware('auth')->name('profile.edit'); // Profila rediģēšana
Route::put('/profile/update', [UserController::class, 'updateProfile'])->middleware('auth')->name('profile.update'); // Profila atjaunināšana
Route::get('/profile/{id}', [UserController::class, 'show'])->name('profile.show'); // Cita lietotāja profils
Route::delete('/profile/{id}', [UserController::class, 'destroy'])->middleware('auth')->name('profile.destroy'); // Lietotāja dzēšana

// Kolekciju pārvaldība
Route::get('/collections/my', [CollectionController::class, 'myCollections'])->middleware('auth')->name('collections.my'); // Lietotāja kolekcijas
Route::post('/collections', [CollectionController::class, 'store'])->middleware('auth')->name('collections.store'); // Jaunas kolekcijas izveide
Route::post('/collections/{id}', [CollectionController::class, 'update'])->middleware('auth')->name('collections.update'); // Kolekcijas atjaunināšana
Route::delete('/collections/{id}', [CollectionController::class, 'destroy'])->middleware('auth')->name('collections.destroy'); // Kolekcijas dzēšana

// Draudzība
Route::post('/friendships', [FriendshipController::class, 'sendRequest'])->middleware('auth')->name('friendships.send'); // Draudzības pieprasījuma sūtīšana
Route::post('/friendships/{id}/accept', [FriendshipController::class, 'acceptRequest'])->middleware('auth')->name('friendships.accept'); // Pieprasījuma apstiprināšana
Route::delete('/friendships/{id}', [FriendshipController::class, 'destroy'])->middleware('auth')->name('friendships.destroy'); // Draudzības attiecību dzēšana

// Administratora funkcijas
Route::get('/admin', [UserController::class, 'adminDashboard'])->middleware('auth')->name('admin.dashboard'); // Admin panelis
Route::post('/users/{id}/privileges', [UserController::class, 'changePrivileges'])->middleware('auth')->name('users.privileges'); // Privilēģiju maiņa

// Fallback maršruts
Route::fallback(function () {
    return redirect()->route('home'); // Neeksistējoša lapa -> novirze uz galveno lapu
});
