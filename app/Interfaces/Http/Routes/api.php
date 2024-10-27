<?php

use App\Interfaces\Http\Controller\AuthenticationsController;
use App\Interfaces\Http\Controller\UserFilesController;
use Illuminate\Support\Facades\Route;
use App\Interfaces\Http\Controller\UsersController;


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
    Route::middleware('ability:role-superadmin,role-admin')->group(function () {
        Route::get('/users/{id}', [UsersController::class, 'getUserById']);
        Route::delete('/users/{id}', [UsersController::class, 'deleteUser']);
        Route::put('/users/{id}', [UsersController::class, 'updateUser']);
        Route::get('/users', [UsersController::class, 'getAllUsers']);
    });
});

Route::post('/users', [UsersController::class, 'addUser']);

Route::post('/authentications', [AuthenticationsController::class, 'login']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/users/files', function (Request $request) {
//         // Your logic to handle the request and return user files
//         return response()->json([
//             'files' => [
//                 // Example file data
//                 ['id' => 1, 'name' => 'file1.txt', 'size' => '15KB'],
//                 ['id' => 2, 'name' => 'file2.jpg', 'size' => '200KB'],
//             ],
//         ]);
//     });

//     Route::post('/users/files', function (Request $request) {
//         $file = $request->file('file');
//         $path = Storage::disk('s3')->put('user_files', $file);

//         return response()->json([
//             'message' => 'File uploaded successfully to S3',
//             'path' => $path,
//         ]);
//     });
// });
