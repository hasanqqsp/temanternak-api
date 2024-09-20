<?php

use App\Infrastructure\Repository\Models\User;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users', function (Request $request) {
    return User::all();
});
Route::get('/users/authentications', function (Request $request) {
    $user = User::first();
    $user->tokens()->delete();
    return [
        "token" => $user->createToken($user->id)->plainTextToken
    ];
});
