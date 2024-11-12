<?php

namespace App\Interfaces\Http\Controller;

use App\Domain\Users\UserRepository;
use App\Domain\Veterinarians\VeterinarianRepository;
use App\Domain\VeterinarianSchedules\VeterinarianScheduleRepository;
use App\Domain\Wallets\WalletLogRepository;
use App\UseCase\Veterinarians\GetAllVeterinarianUseCase;
use App\UseCase\Veterinarians\GetVeterinarianByIdUseCase;
use App\UseCase\Veterinarians\GetVeterinarianByUsernameUseCase;
use App\UseCase\Veterinarians\GetVeterinarianWalletUseCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class VeterinariansController extends Controller
{
    private $getVeterinarianByIdUseCase;
    private $getVeterinarianByUsernameUseCase;
    private $getAllVeterinarianUseCase;
    private $getVeterinarianWalletUseCase;
    public function __construct(
        VeterinarianRepository $veterinarianRepository,
        VeterinarianScheduleRepository $scheduleRepository,
        UserRepository $userRepository,
        WalletLogRepository $walletLogRepository
    ) {
        $this->getVeterinarianByIdUseCase = new GetVeterinarianByIdUseCase($veterinarianRepository, $scheduleRepository);
        $this->getVeterinarianByUsernameUseCase = new GetVeterinarianByUsernameUseCase($veterinarianRepository);
        $this->getAllVeterinarianUseCase = new GetAllVeterinarianUseCase($veterinarianRepository);
        $this->getVeterinarianWalletUseCase = new GetVeterinarianWalletUseCase($userRepository, $walletLogRepository);
    }

    public function getById($id)
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->getVeterinarianByIdUseCase->execute($id)->toArray()
        ];
        return response()->json($responseArray);
    }

    public function get()
    {
        $data = [];
        $username = request()->query('username');
        if ($username) {
            $data = $this->getVeterinarianByUsernameUseCase->execute($username);
        } else {
            $data = $this->getAllVeterinarianUseCase->execute();
        }
        $responseArray = [
            "status" => "success",
            "data" => $data
        ];
        return response()->json($responseArray);
    }

    public function getByUsername()
    {
        $username = request()->query('username');
        $responseArray = [
            "status" => "success",
            "data" => $this->getVeterinarianByUsernameUseCase->execute($username)
        ];
        return response()->json($responseArray);
    }

    public function getMyWallet(Request $request)
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->getVeterinarianWalletUseCase->execute($request->user()->id)
        ];
        return response()->json($responseArray);
    }
}
