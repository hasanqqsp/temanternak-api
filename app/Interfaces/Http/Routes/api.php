<?php

use App\Interfaces\Http\Controller\AuthenticationsController;
use App\Interfaces\Http\Controller\InvitationsController;
use App\Interfaces\Http\Controller\UserFilesController;
use Illuminate\Support\Facades\Route;
use App\Interfaces\Http\Controller\UsersController;
use App\Interfaces\Http\Controller\VeterinariansController;


use App\Interfaces\Http\Controller\VeterinarianRegistrationsController;
use App\Interfaces\Http\Controller\VeterinarianVerificationController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/my', [AuthenticationsController::class, 'getMyAccount'])->middleware('auth:sanctum');
    Route::patch('/users/my/password', [UsersController::class, 'changeUserPassword']);
    Route::put('/users/my/profile/', [UsersController::class, 'updateMyProfile']);
    Route::delete('/authentications', [AuthenticationsController::class, 'logout']);
    Route::post('/users/my/files', [UserFilesController::class, 'store']);
    Route::get('/users/my/files', [UserFilesController::class, 'index']);
    Route::delete('/users/my/files', [UserFilesController::class, 'delete']);
    Route::get('/users/my/files/{fileId}', [UserFilesController::class, 'getById']);
    Route::delete('/users/my/files/{fileId}', [UserFilesController::class, 'deleteById']);
    Route::get('/users/my/files', [UserFilesController::class, 'index']);
    Route::middleware('ability:role-invited-user')->group(function () {
        Route::put('/registrations/veterinarians', [VeterinarianRegistrationsController::class, 'revise']);
        Route::post('/registrations/veterinarians', [VeterinarianRegistrationsController::class, 'create']);
    });
    Route::middleware('ability:role-veterinarian,role-invited-user')->group(function () {
        Route::get('/users/my/registrations', [VeterinarianRegistrationsController::class, 'getMy']);
        Route::get('/registrations/veterinarians/my', [VeterinarianRegistrationsController::class, 'getMy']);
    });
    Route::middleware('ability:role-superadmin,role-admin')->group(function () {
        Route::get('/users/{id}', [UsersController::class, 'getUserById']);
        Route::delete('/users/{id}', [UsersController::class, 'deleteUser']);
        Route::put('/users/{id}', [UsersController::class, 'updateUser']);
        Route::get('/users/{userId}/registrations', [VeterinarianRegistrationsController::class, 'getByUserId']);
        Route::get('/users', [UsersController::class, 'getAllUsers']);
        Route::post('/invitations', [InvitationsController::class, 'create']);
        Route::get('/invitations', [InvitationsController::class, 'getAll']);
        Route::delete('/invitations/{id}', [InvitationsController::class, 'revoke']);
        Route::get('/registrations/veterinarians', [VeterinarianRegistrationsController::class, 'getAll']);
        Route::get('/registrations/veterinarians/{registrationId}', [VeterinarianRegistrationsController::class, 'getById']);
        Route::post('/registrations/veterinarians/{registrationId}/verification', [VeterinarianVerificationController::class, 'add']);
        Route::put('/registrations/veterinarians/{registrationId}/verification', [VeterinarianVerificationController::class, 'edit']);
    });
});
Route::get('/invitations/{id}', [InvitationsController::class, 'get']);

Route::post('/users', [UsersController::class, 'addUser']);

Route::post('/authentications', [AuthenticationsController::class, 'login']);

Route::get('/veterinarians/{id}', [VeterinariansController::class, 'getById']);
Route::get('/veterinarians', [VeterinariansController::class, 'get']);

Route::get('/user_files/{pathname}', [UserFilesController::class, 'getByPathname'])->where('pathname', '.*');
