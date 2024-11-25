<?php

namespace App\Interfaces\Http\Controller;

use App\Domain\Review\ReviewRepository;
use App\Domain\ServiceBookings\ServiceBookingRepository;
use App\Domain\Users\UserRepository;
use App\UseCase\Dashboards\GetAdminDashboardDataUseCase;
use App\UseCase\Dashboards\GetVeterinarianDashboardUseCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardsController extends Controller
{
    private $getAdminDashboardDataUseCase;
    private $getVeterinarianDashboardUseCase;

    public function __construct(UserRepository $userRepository, ServiceBookingRepository $serviceBookingRepository, ReviewRepository $reviewRepository)
    {
        $this->getAdminDashboardDataUseCase = new GetAdminDashboardDataUseCase($userRepository, $serviceBookingRepository);
        $this->getVeterinarianDashboardUseCase = new GetVeterinarianDashboardUseCase($reviewRepository, $serviceBookingRepository);
    }

    public function admin()
    {
        return response()->json([
            "status" => "success",
            "data" => $this->getAdminDashboardDataUseCase->execute()
        ]);
    }

    public function veterinarian(Request $request)
    {
        return response()->json([
            "status" => "success",
            "data" => $this->getVeterinarianDashboardUseCase->execute($request->user()->id)
        ]);
    }
}
