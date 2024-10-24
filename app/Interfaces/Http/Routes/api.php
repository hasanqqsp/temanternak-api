<?php

use App\Domain\Users\Entities\NewUser;
use App\Domain\Users\Entities\User as EntityUser;
use App\Infrastructure\Repository\Eloquent\UserRepositoryEloquent;
use App\Infrastructure\Repository\Models\User;
use Hidehalo\Nanoid\Client;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;


Route::get('/users', function (Request $request) {
    $allUsers =  User::all()->toArray();

    $mappedUsers = array_map(function ($user) {
        return new EntityUser($user["id"], $user["name"], $user["email"], $user["created_at"], $user["updated_at"]);
    }, $allUsers);
    return response()->json([
        'status' => 'success',
        'data' => $mappedUsers,
    ]);
});

Route::post('/users', function (Request $request) {
    try {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $newUser = new NewUser(
            $validatedData['name'],
            $validatedData['email'],
            $validatedData['password'],
            'basic'
        );

        $userRepository = new UserRepositoryEloquent();
        $user = $userRepository->create($newUser);


        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'data' => [
                'id' => $user->id,
                'created_at' => $user->created_at,
            ]
        ], 201);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(
            [
                "status" => "fail",
                "message" => "There was an error with the data provided",
                "errors" => $e->errors()
            ],
            400
        );
    }
});

Route::delete('/users/{id}', function ($id) {
    $user = User::find($id);

    if (!$user) {
        return response()->json([
            'status' => 'fail',
            'message' => 'User not found'
        ], 404);
    }

    $user->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'User deleted successfully'
    ]);
});

Route::post('/users/authentications', function (Request $request) {
    if (Auth::attempt($request->only('email', 'password'))) {
        $user = Auth::user();
        $token = $user->createToken('auth_token', ['user:' + $user->role])->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    return response()->json(['error' => 'Unauthorized'], 401);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/files', function (Request $request) {
        // Your logic to handle the request and return user files
        return response()->json([
            'files' => [
                // Example file data
                ['id' => 1, 'name' => 'file1.txt', 'size' => '15KB'],
                ['id' => 2, 'name' => 'file2.jpg', 'size' => '200KB'],
            ],
        ]);
    });

    Route::post('/users/files', function (Request $request) {
        $file = $request->file('file');
        $path = Storage::disk('s3')->put('user_files', $file);

        return response()->json([
            'message' => 'File uploaded successfully to S3',
            'path' => $path,
        ]);
    });
});
