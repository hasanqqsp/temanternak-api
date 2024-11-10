<?php

namespace App\Interfaces\Http\Controller;

use App\Domain\VeterinarianSchedules\Entities\NewVeterinarianSchedule;
use App\Domain\VeterinarianSchedules\VeterinarianScheduleRepository;
use App\Domain\VeterinarianServices\VeterinarianServiceRepository;
use App\UseCase\VeterinarianSchedules\AddVeterinarianScheduleUseCase;
use App\UseCase\VeterinarianSchedules\GetAllAvailableStartTimesByServiceId;
use App\UseCase\VeterinarianSchedules\GetFutureSchedulesUseCaseByVeterinarianIdUseCase;
use App\UseCase\VeterinarianSchedules\GetScheduleByVeterinarianIdUseCase;
use App\UseCase\VeterinarianSchedules\RemoveVeterinarianScheduleUseCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class VeterinarianSchedulesController extends Controller
{
    private $addVeterinarianScheduleUseCase;
    private $removeVeterinarianScheduleUseCase;
    private $getScheduleByVeterinarianIdUseCase;
    private $getAllAvailableStartTimesByServiceId;
    private $getAllFutureScheduleByVeterinarianId;


    public function __construct(VeterinarianScheduleRepository $repository, VeterinarianServiceRepository $veterinarianServiceRepository)
    {
        $this->addVeterinarianScheduleUseCase = new AddVeterinarianScheduleUseCase($repository);
        $this->removeVeterinarianScheduleUseCase = new RemoveVeterinarianScheduleUseCase($repository);
        $this->getScheduleByVeterinarianIdUseCase = new GetScheduleByVeterinarianIdUseCase($repository);
        $this->getAllAvailableStartTimesByServiceId = new GetAllAvailableStartTimesByServiceId($repository, $veterinarianServiceRepository);
        $this->getAllFutureScheduleByVeterinarianId = new GetFutureSchedulesUseCaseByVeterinarianIdUseCase($repository);
    }

    public function add(Request $request)
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->addVeterinarianScheduleUseCase->execute(new NewVeterinarianSchedule(
                $request->user()->id,
                $request->startTime,
                $request->endTime
            ))->toArray()
        ];
        return response()->json($responseArray);
    }

    public function remove(Request $request, $scheduleId)
    {
        $this->removeVeterinarianScheduleUseCase->execute($scheduleId, $request->user()->id);
        $responseArray = [
            "status" => "success",
            "data" => "Schedule removed successfully."
        ];
        return response()->json($responseArray);
    }
    public function getMy(Request $request)
    {
        if ($request->query('only_future') == 'true') {
            $responseArray = [
                "status" => "success",
                "data" => $this->getAllFutureScheduleByVeterinarianId->execute($request->user()->id)
            ];
            return response()->json($responseArray);
        }
        $responseArray = [
            "status" => "success",
            "data" => $this->getScheduleByVeterinarianIdUseCase->execute($request->user()->id)
        ];
        return response()->json($responseArray);
    }

    public function getAvailableStartTimes(Request $request, $serviceId)
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->getAllAvailableStartTimesByServiceId->execute($serviceId)
        ];
        return response()->json($responseArray);
    }
}
