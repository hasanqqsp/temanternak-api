<?php

namespace App\Interfaces\Http\Controller;

use App\Domain\Users\Entities\User as UserEntity;
use App\Domain\Users\UserRepository;
use App\Infrastructure\Repository\Models\User;
use App\Services\Hash\HashingServiceInterface;
use App\UseCase\Authentications\LoginUseCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AuthenticationsController extends Controller
{
    protected $loginUseCase;
    public function __construct(UserRepository $userRepository, HashingServiceInterface $hashingService)
    {
        $this->loginUseCase = new LoginUseCase($userRepository, $hashingService);
    }
    /**
     * Handle user login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $token = $this->loginUseCase->execute($request->email, $request->password);
        return response()->json([
            'status' => 'success',
            'token' => $token,
        ]);
    }

    /**
     * Handle user logout.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out'
        ]);
    }

    public function getMyAccount(Request $request)
    {
        $user = $request->user();
        $userData = (new UserEntity(
            $user->id,
            $user->name,
            $user->email,
            $user->created_at,
            $user->updated_at,
            $user->role,
            $user->phone,
            $user->username
        ))->toArray();
        return response()->json([
            "status" => "success",
            "message" => "You're login as " . $user->name,
            "data" => $userData
        ]);
    }
}
