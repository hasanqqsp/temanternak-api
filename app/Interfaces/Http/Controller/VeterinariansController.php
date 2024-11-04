<?php

namespace App\Interfaces\Http\Controller;

use App\Domain\Veterinarians\VeterinarianRepository;
use App\Domain\VeterinarianSchedules\VeterinarianScheduleRepository;
use App\UseCase\Veterinarians\GetAllVeterinarianUseCase;
use App\UseCase\Veterinarians\GetVeterinarianByIdUseCase;
use App\UseCase\Veterinarians\GetVeterinarianByUsernameUseCase;
use Illuminate\Routing\Controller;


class VeterinariansController extends Controller
{
    private $getVeterinarianByIdUseCase;
    private $getVeterinarianByUsernameUseCase;
    private $getAllVeterinarianUseCase;

    public function __construct(VeterinarianRepository $veterinarianRepository, VeterinarianScheduleRepository $scheduleRepository)
    {
        $this->getVeterinarianByIdUseCase = new GetVeterinarianByIdUseCase($veterinarianRepository, $scheduleRepository);
        $this->getVeterinarianByUsernameUseCase = new GetVeterinarianByUsernameUseCase($veterinarianRepository);
        $this->getAllVeterinarianUseCase = new GetAllVeterinarianUseCase($veterinarianRepository);
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
}
