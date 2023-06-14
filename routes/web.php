<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Profile\AvatarController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

Route::get('/', function () {
    return view('home');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [AvatarController::class, 'update'])->name('avatar.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::post('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
})->name('login.github');
 

Route::get('/auth/callback', function () {
    
    $user = Socialite::driver('github')->user();
    $user = User::firstOrCreate([
        'email' => strtolower($user->email)
    ], [
        'name' => strtolower($user->name),
        'avatar' => 'avatars/default-user.jpg',
        'password' => 'password',
    ]);
 
    Auth::login($user);
 
    return redirect()->route('ticket.index');
});

  
Route::middleware('auth')->group(function () {
    Route::resource('ticket', TicketController::class);
    Route::get('verify', [TicketController::class, 'verify'])->name('ticket.verify');
    Route::get('personal', [TicketController::class, 'personal'])->name('ticket.personal');
});






