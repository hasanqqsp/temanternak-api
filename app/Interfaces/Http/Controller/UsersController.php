<?php

namespace App\Interfaces\Http\Controller;

use Illuminate\Routing\Controller;

class UsersController extends Controller
{
    private $getAllUsersUseCase;
    private $getUserByIdUseCase;

    public function __construct($getAllUsersUseCase, $getUserByIdUseCase)
    {
        $this->getAllUsersUseCase = $getAllUsersUseCase;
        $this->getUserByIdUseCase = $getUserByIdUseCase;
    }

    public function getAllUsers()
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->getAllUsersUseCase->execute()
        ];
        return response()->json($responseArray);
    }

    public function getUserById($id)
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->getUserByIdUseCase->execute($id)
        ];
        return response()->json($responseArray);
    }

    // public function show($id)
    // {
    //     $user = User::find($id);
    //     if ($user) {
    //         return response()->json($user);
    //     } else {
    //         return response()->json(['message' => 'User not found'], 404);
    //     }
    // }

    // public function store(Request $request)
    // {
    //     $user = User::create($request->all());
    //     return response()->json($user, 201);
    // }

    // public function update(Request $request, $id)
    // {
    //     $user = User::find($id);
    //     if ($user) {
    //         $user->update($request->all());
    //         return response()->json($user);
    //     } else {
    //         return response()->json(['message' => 'User not found'], 404);
    //     }
    // }

    // public function destroy($id)
    // {
    //     $user = User::find($id);
    //     if ($user) {
    //         $user->delete();
    //         return response()->json(['message' => 'User deleted']);
    //     } else {
    //         return response()->json(['message' => 'User not found'], 404);
    //     }
    // }
}
