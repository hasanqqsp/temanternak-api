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
use App\UseCase\ServiceBooking\CancelServiceBookingUseCase;
use App\UseCase\ServiceBooking\GetAllConfirmedServiceBookingsByVeterinarianIdUseCase;
use App\UseCase\ServiceBooking\GetAllServiceBookingsByCustomerIdUseCase;
use App\UseCase\ServiceBooking\GetAllServiceBookingsByVeterinarianIdUseCase;
use App\UseCase\ServiceBooking\GetAllServiceBookingsUseCase;
use App\UseCase\ServiceBooking\GetServiceBookingByIdForAdminUseCase;
use App\UseCase\ServiceBooking\GetServiceBookingByIdUseCase;
use App\UseCase\ServiceBooking\RescheduleBookingUseCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ServiceBookingsController extends Controller
{
    private $addServiceBookingUseCase;
    private $getAllConfirmedServiceBookingsByVeterinarianIdUseCase;
    private $getAllServiceBookingsByCustomerIdUseCase;
    private $getAllServiceBookingsByVeterinarianIdUseCase;
    private $getAllServiceBookingsUseCase;
    private $cancelServiceBookingUseCase;
    private $getServiceBookingByIdUseCase;
    private $getServiceBookingForAdminByIdUseCase;
    private $rescheduleServiceBookingUseCase;

    public function __construct(
        ServiceBookingRepository $serviceBookingRepository,
        TransactionRepository $transactionRepository,
        VeterinarianServiceRepository $veterinarianServiceRepository,
        VeterinarianScheduleRepository $veterinarianScheduleRepository
    ) {
        $midtransPaymentGateway = new MidtransPaymentGateway();
        $this->addServiceBookingUseCase = new AddServiceBookingUseCase(
            $serviceBookingRepository,
            $transactionRepository,
            $veterinarianServiceRepository,
            $veterinarianScheduleRepository,
            $midtransPaymentGateway
        );
        $this->getAllServiceBookingsUseCase = new GetAllServiceBookingsUseCase($serviceBookingRepository);
        $this->getAllServiceBookingsByCustomerIdUseCase = new GetAllServiceBookingsByCustomerIdUseCase($serviceBookingRepository);
        $this->getAllServiceBookingsByVeterinarianIdUseCase = new GetAllServiceBookingsByVeterinarianIdUseCase($serviceBookingRepository);
        $this->getAllConfirmedServiceBookingsByVeterinarianIdUseCase = new GetAllConfirmedServiceBookingsByVeterinarianIdUseCase($serviceBookingRepository);
        $this->cancelServiceBookingUseCase = new CancelServiceBookingUseCase($serviceBookingRepository, $transactionRepository, $midtransPaymentGateway);
        $this->getServiceBookingByIdUseCase = new GetServiceBookingByIdUseCase($serviceBookingRepository);
        $this->getServiceBookingForAdminByIdUseCase = new GetServiceBookingByIdForAdminUseCase($serviceBookingRepository);
        $this->rescheduleServiceBookingUseCase = new RescheduleBookingUseCase($serviceBookingRepository, $veterinarianScheduleRepository);
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

    public function getAll(Request $request)
    {
        $role = $request->user()->role;
        if ($role == "veterinarian") {
            if ($request->query('only_confirmed') == 'true') {
                $responseArray = [
                    "status" => "success",
                    "data" => $this->getAllConfirmedServiceBookingsByVeterinarianIdUseCase->execute($request->user()->id)
                ];
                return response()->json($responseArray);
            }
            $responseArray = [
                "status" => "success",
                "data" => $this->getAllServiceBookingsByVeterinarianIdUseCase->execute($request->user()->id)
            ];
            return response()->json($responseArray);
        }

        if ($role == "admin" || $role == "superadmin") {
            $responseArray = [
                "status" => "success",
                "data" => $this->getAllServiceBookingsUseCase->execute()
            ];
            return response()->json($responseArray);
        }

        $responseArray = [
            "status" => "success",
            "data" => $this->getAllServiceBookingsByCustomerIdUseCase->execute($request->user()->id)
        ];
        return response()->json($responseArray);
    }

    public function cancel(Request $request, $bookingId)
    {
        $this->cancelServiceBookingUseCase->execute($bookingId, $request->user()->id);
        $responseArray = [
            "status" => "success",
            "message" => "Booking successfully cancelled"
        ];
        return response()->json($responseArray);
    }

    public function getById(Request $request, $bookingId)
    {
        $role = $request->user()->role;
        if ($role == "admin" || $role == "superadmin") {
            $responseArray = [
                "status" => "success",
                "data" => $this->getServiceBookingForAdminByIdUseCase->execute($bookingId)->toArray()
            ];
            return response()->json($responseArray);
        }
        $responseArray = [
            "status" => "success",
            "data" => $this->getServiceBookingByIdUseCase->execute($bookingId, $request->user()->id)->toArray()
        ];
        return response()->json($responseArray);
    }

    public function reschedule(Request $request, $bookingId)
    {
        $this->rescheduleServiceBookingUseCase->execute($bookingId, $request->startTime, $request->user()->id);
        return response()->json([
            "status" => "success",
            "message" => "Booking successfully rescheduled"
        ]);
    }
    public function getMy() {}
}
