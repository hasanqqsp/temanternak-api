<?php

namespace App\Interfaces\Http\Controller;

use App\Domain\Invitations\InvitationRepository;
use App\Domain\Users\Entities\ChangeUserPassword;
use App\Domain\Users\Entities\NewUser;
use App\Domain\Users\Entities\UpdateUser;
use App\Domain\Users\UserRepository;
use App\Services\Hash\HashingServiceInterface;
use App\UseCase\Users\AddUserByInvitationUseCase;
use App\UseCase\Users\AddUserUseCase;
use App\UseCase\Users\ChangeUserPasswordUseCase;
use App\UseCase\Users\DeleteUserUseCase;
use App\UseCase\Users\GetAllPublicUsersUseCase;
use App\UseCase\Users\GetAllUsersUseCase;
use App\UseCase\Users\GetUserByIdUseCase;
use App\UseCase\Users\GetUserByUsernameUseCase;
use App\UseCase\Users\UpdateUserUseCase;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    private $getAllUsersUseCase;
    private $getUserByIdUseCase;
    private $addUserUseCase;
    private $deleteUserUseCase;
    private $getAllPublicUsersUseCase;
    private $getUserByUsernameUseCase;
    private $updateUserUseCase;
    private $changeUserPasswordUseCase;
    private $addUserByInvitationUseCase;

    public function __construct(
        UserRepository $userRepository,
        InvitationRepository $invitationRepository,
        HashingServiceInterface $hashingService,
    ) {
        $this->getAllUsersUseCase = new GetAllUsersUseCase($userRepository);
        $this->getUserByIdUseCase = new GetUserByIdUseCase($userRepository);
        $this->addUserUseCase = new AddUserUseCase($userRepository);
        $this->deleteUserUseCase = new DeleteUserUseCase($userRepository);
        $this->getAllPublicUsersUseCase = new GetAllPublicUsersUseCase($userRepository);
        $this->getUserByUsernameUseCase = new GetUserByUsernameUseCase($userRepository);
        $this->updateUserUseCase = new UpdateUserUseCase($userRepository);
        $this->changeUserPasswordUseCase = new ChangeUserPasswordUseCase($userRepository, $hashingService);
        $this->addUserByInvitationUseCase = new AddUserByInvitationUseCase($userRepository, $invitationRepository);
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
            "data" => $this->getUserByIdUseCase->execute($id)->toArray()
        ];
        return response()->json($responseArray);
    }

    public function addUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'string',
            'phone' => 'required|string|max:15',
            'username' => 'required|string|max:255|unique:users',
            'invitation_id' => 'string'
        ]);

        $useCase = ($request->has('invitationId')) ? $this->addUserByInvitationUseCase : $this->addUserUseCase;
        $data = $useCase->execute(new NewUser(
            $request->name,
            $request->email,
            Hash::make($request->password),
            $request->phone,
            $request->username,
            $request->invitationId,
            $request->role
        ))->toArray();

        $responseArray = [
            "status" => "success",
            "data" => $data
        ];
        return response()->json($responseArray, 201);
    }

    public function deleteUser($id)
    {
        $this->deleteUserUseCase->execute($id);
        return response()->json([
            'status' => 'success',
            'message' => 'User successfully deleted'
        ]);
    }

    public function getAllPublicUsers()
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->getAllPublicUsersUseCase->execute()
        ];
        return response()->json($responseArray);
    }

    public function getUserByUsername($username)
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->getUserByUsernameUseCase->execute($username)
        ];
        return response()->json($responseArray);
    }

    public function updateMyProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:15',
            'username' => 'required|string|max:255',
        ]);

        $user = $request->user();

        $this->updateUserUseCase->execute(new UpdateUser(
            $user->id,
            $request->name,
            $request->email,
            $request->phone,
            $user->role,
            $request->username
        ));

        $responseArray = [
            "status" => "success",
            "data" => "User successfully updated"
        ];
        return response()->json($responseArray);
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'role' => 'required|string',
            'phone' => 'required|string|max:15',
            'username' => 'required|string|max:255',
        ]);

        $this->updateUserUseCase->execute(new UpdateUser(
            $id,
            $request->name,
            $request->email,
            $request->phone,
            $request->role,
            $request->username
        ));

        $responseArray = [
            "status" => "success",
            "data" => "User successfully updated"
        ];
        return response()->json($responseArray);
    }

    public function changeUserPassword(Request $request)
    {
        $id = request()->user()->id;
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
            'old_password' => 'required'
        ]);

        $this->changeUserPasswordUseCase->execute(new ChangeUserPassword($id, $request->old_password, $request->password));

        $responseArray = [
            "status" => "success",
            "message" => "User password successfully changed"
        ];
        return response()->json($responseArray);
    }
}
