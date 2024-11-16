<?php

namespace App\Interfaces\Http\Controller;

use App\Domain\Consultations\ConsultationRepository;
use App\Domain\ServiceBookings\ServiceBookingRepository;
use App\Domain\Users\UserRepository;
use App\Infrastructure\Tokenizer\JWTService;
use App\UseCase\Consultations\CustomerJoinConsultationRoomUseCase;
use App\UseCase\Consultations\GetConsultationByBookingIdUseCase;
use App\UseCase\Consultations\GetConsultationByCustomerIdUseCase;
use App\UseCase\Consultations\GetConsultationByVeterinarianIdAndStatusUseCase;
use App\UseCase\Consultations\GetConsultationByVeterinarianIdUseCase;
use App\UseCase\Consultations\VeterinarianJoinConsultationRoomUseCase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ConsultationsController extends Controller
{
    protected $customerJoinConsultationRoomUseCase;
    protected $getConsultationByBookingIdUseCase;
    protected $getConsultationByVeterinarianIdAndStatusUseCase;
    protected $getConsultationByVeterinarianIdUseCase;
    protected $getConsultationByCustomerIdUseCase;
    protected $veterinarianJoinConsultationRoomUseCase;
    protected $jwtService;

    public function __construct(UserRepository $userRepository, ConsultationRepository $consultationRepository, ServiceBookingRepository $bookingRepository)
    {
        $this->customerJoinConsultationRoomUseCase = new CustomerJoinConsultationRoomUseCase($userRepository, $bookingRepository, $consultationRepository);
        $this->getConsultationByBookingIdUseCase = new GetConsultationByBookingIdUseCase($consultationRepository, $bookingRepository);
        $this->getConsultationByVeterinarianIdAndStatusUseCase = new GetConsultationByVeterinarianIdAndStatusUseCase($consultationRepository);
        $this->getConsultationByVeterinarianIdUseCase = new GetConsultationByVeterinarianIdUseCase($consultationRepository);
        $this->getConsultationByCustomerIdUseCase = new GetConsultationByCustomerIdUseCase($consultationRepository);
        $this->veterinarianJoinConsultationRoomUseCase = new VeterinarianJoinConsultationRoomUseCase($userRepository, $bookingRepository, $consultationRepository);
        $this->jwtService = new JWTService();
    }

    public function getByBookingId(Request $request)
    {
        $consultation = $this->getConsultationByBookingIdUseCase->execute($request->bookingId, $request->user()->id);
        $responseArray = [
            "status" => "success",
            "data" => $this->getConsultationByBookingIdUseCase->execute($request->bookingId, $request->user()->id)->toArray()
        ];
        $responseArray['data']["token"] = $this->jwtService->generate((array) [
            'userId' => $request->user()->id,
            'roomId' => $consultation->getId(),
            'actualStartTime' => $consultation->getStartTime(),
        ], (new Carbon($consultation->getEndTime()))->addSeconds(10), (new Carbon($consultation->getStartTime()))->subSecond(10));

        return response()->json($responseArray);
    }

    public function getMy(Request $request)
    {
        if ($request->user()->role == 'veterinarian') {
            if (request()->has('status')) {
                $responseArray = [
                    "status" => "success",
                    "data" => $this->getConsultationByVeterinarianIdAndStatusUseCase->execute(
                        $request->user()->id,
                        $request->query('status')
                    )
                ];

                return response()->json($responseArray);
            }
            $responseArray = [
                "status" => "success",
                "data" => $this->getConsultationByVeterinarianIdUseCase->execute($request->user()->id)
            ];
            return response()->json($responseArray);
        } else {
            $responseArray = [
                "status" => "success",
                "data" => $this->getConsultationByCustomerIdUseCase->execute($request->user()->id)
            ];
            return response()->json($responseArray);
        }
    }

    public function getByVeterinarianId(Request $request, $veterinarianId)
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->getConsultationByVeterinarianIdUseCase->execute($veterinarianId)
        ];
        return response()->json($responseArray);
    }

    public function getByCustomerId(Request $request, $customerId)
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->getConsultationByCustomerIdUseCase->execute($customerId)
        ];
        return response()->json($responseArray);
    }

    public function join(Request $request, $bookingId)
    {
        if ($request->user()->role == 'veterinarian') {
            $this->veterinarianJoinConsultationRoomUseCase->execute($bookingId, $request->user()->id);
        } else {
            $this->customerJoinConsultationRoomUseCase->execute($bookingId, $request->user()->id);
        }
        return response()->json([
            "status" => "success",
            "message" => "You have successfully joined the consultation room"
        ]);
    }
}
