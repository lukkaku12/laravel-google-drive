<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;


//GOOGLE OAUTH 

Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->stateless()->redirect();
});



Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->stateless()->user();

    // Buscar o crear el usuario
    $user = User::firstOrCreate([
        'email' => $googleUser->getEmail(),
    ], [
        'name' => $googleUser->getName(),
        'password' => bcrypt(Str::random(24)), // Solo por si acaso
        'google_id' => $googleUser->getId(),
    ]);
    
    $token = JWTAuth::fromUser($user);

    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
        'user' => $user,
    ]);
});


Route::prefix('auth')
    ->middleware('api')
    ->group(base_path('routes/auth.php'));


Route::middleware(['jwt.auth'])->group(base_path('routes/files.php'));



// Route::middleware(['jwt.auth'])->get('/user', function (Request $request) {
//     return $request->user();
// });
