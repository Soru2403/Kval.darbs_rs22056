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
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); // Pieteikšanās formas parādīšana
Route::post('/login', [AuthController::class, 'login'])->name('login.post'); // Pieteikšanās pieprasījuma apstrāde
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Izrakstīšanās pieprasījuma apstrāde

// Publiskās sadaļas
Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index'); // Publiskās kolekcijas
Route::get('/collections/popular', [CollectionController::class, 'popular'])->name('collections.popular'); // Populārās kolekcijas

// Foruma galvenā lapa ar iespēju norādīt kārtošanas virzienu
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index'); // Pieņem parametru 'sort' kārtošanas virzienam (asc vai desc)
Route::get('/forum/{id}', [ForumController::class, 'show'])->name('forum.show'); // Foruma ieraksta skatīšana
Route::get('/media', [MediaController::class, 'index'])->name('media.index'); // Mediju saraksts
Route::get('/media/{id}', [MediaController::class, 'show'])->name('media.show'); // Konkrētā medija detaļas

// Papildmaršruti kļūdām un statiskām lapām
Route::view('/error', 'errors.general')->name('error'); // Kļūdu lapa

// Funkcijas tikai reģistrētiem lietotājiem
    // Lietotāja profils
    Route::get('/profile', [UserController::class, 'profile'])->name('profile'); // Lietotāja profila skatīšana
    Route::get('/profile/{id}', [UserController::class, 'show'])->name('profile.show'); // Cita lietotāja profila skatīšana

    // Kolekciju pārvaldība
    Route::get('/collections/my', [CollectionController::class, 'myCollections'])->name('collections.my'); // Lietotāja kolekcijas
    Route::post('/collections', [CollectionController::class, 'store'])->name('collections.store'); // Jaunas kolekcijas izveidošana
    Route::post('/collections/{id}', [CollectionController::class, 'update'])->name('collections.update'); // Esošas kolekcijas rediģēšana
    Route::delete('/collections/{id}', [CollectionController::class, 'destroy'])->name('collections.destroy'); // Kolekcijas dzēšana

    // Forums
    Route::get('/forum/create', [ForumController::class, 'create'])->middleware('auth')->name('forum.create');
    Route::post('/forum', [ForumController::class, 'store'])->middleware('auth')->name('forum.store');
    Route::get('/forum/search', [ForumController::class, 'search'])->name('forum.search'); // Meklēšana pēc nosaukuma vai atslēgvārdiem
    Route::post('/forum/{id}/comment', [ForumController::class, 'comment'])->name('forum.comment'); // Komentāra pievienošana ierakstam
    Route::delete('/forum/{id}', [ForumController::class, 'destroyPost'])->name('forum.destroy'); // Foruma ieraksta dzēšana (tikai autors/admins)

    // Draudzība
    Route::post('/friendships', [FriendshipController::class, 'sendRequest'])->name('friendships.send'); // Draudzības pieprasījuma nosūtīšana
    Route::post('/friendships/{id}/accept', [FriendshipController::class, 'acceptRequest'])->name('friendships.accept'); // Pieprasījuma apstiprināšana
    Route::delete('/friendships/{id}', [FriendshipController::class, 'destroy'])->name('friendships.destroy'); // Draudzības attiecību dzēšana

    // Vērtējumi un mijiedarbība ar multividi
    Route::post('/media/{id}/rate', [MediaController::class, 'rate'])->name('media.rate'); // Medija vērtēšana

// Funkcijas administratoriem
Route::middleware(['auth', 'admin'])->group(function () {  // Šeit pievienojam papildus 'admin' middleware, lai pārvaldītu administrēšanas maršrutus
    Route::get('/admin', [UserController::class, 'adminDashboard'])->name('admin.dashboard'); // Administratora panelis
    Route::delete('/forum/{id}', [ForumController::class, 'destroyPost'])->name('forum.destroy'); // Foruma ieraksta dzēšana (admina tiesības)
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy'); // Lietotāja dzēšana
    Route::post('/users/{id}/privileges', [UserController::class, 'changePrivileges'])->name('users.privileges'); // Lietotāja privilēģiju maiņa
});

// Nodrošinām, ka jebkura neatpazīta lapa tiek novirzīta uz kļūdu vai sākumlapu
Route::fallback(function () {
    return redirect()->route('home'); // Ja lapa nav atrasta, novirzām uz galveno lapu
});




