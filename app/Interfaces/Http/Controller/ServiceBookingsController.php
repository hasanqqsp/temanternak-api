<?php

namespace App\Interfaces\Http\Controller;

use App\Domain\ServiceBookings\Entities\NewBooking;
use App\Domain\ServiceBookings\ServiceBookingRepository;
use App\Domain\Transactions\TransactionRepository;
use App\Domain\Veterinarians\Entities\Veterinarian;
use App\Domain\VeterinarianSchedules\VeterinarianScheduleRepository;
use App\Domain\VeterinarianServices\VeterinarianServiceRepository;
use App\Infrastructure\Payment\MidtransPaymentGateway;
use App\UseCase\ServiceBooking\AddServiceBookingUseCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ServiceBookingsController extends Controller
{
    private $addServiceBookingUseCase;

    public function __construct(
        ServiceBookingRepository $serviceBookingRepository,
        TransactionRepository $transactionRepository,
        VeterinarianServiceRepository $veterinarianServiceRepository,
        VeterinarianScheduleRepository $veterinarianScheduleRepository
    ) {
        $this->addServiceBookingUseCase = new AddServiceBookingUseCase(
            $serviceBookingRepository,
            $transactionRepository,
            $veterinarianServiceRepository,
            $veterinarianScheduleRepository,
            new MidtransPaymentGateway()
        );
    }

    public function add(Request $request, $veterinarianId, $serviceId)
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->addServiceBookingUseCase->execute(new NewBooking(
                $serviceId,
                $request->startTime,
                $request->user()->id,
                $veterinarianId
            ))->toArray()
        ];
        return response()->json($responseArray);
    }
}
