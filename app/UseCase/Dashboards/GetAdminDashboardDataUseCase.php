<?php

namespace App\UseCase\Dashboards;


use App\Domain\ServiceBookings\ServiceBookingRepository;
use App\Domain\Users\UserRepository;


class GetAdminDashboardDataUseCase
{
    private $userRepository;
    private $veterinarianRepository;
    private $serviceBookingRepository;

    public function __construct(UserRepository $userRepository, ServiceBookingRepository $serviceBookingRepository)
    {
        $this->userRepository = $userRepository;
        $this->serviceBookingRepository = $serviceBookingRepository;
    }
    public function execute()
    {
        // Your logic to get admin dashboard data goes here
        // For example, you might fetch data from the database and return it

        $data = [
            'totalUsers' => $this->userRepository->getTotalBasicUsers(),
            'totalVeterinarian' => $this->userRepository->getTotalVeterinarians(),
            'totalTransactions' => $this->serviceBookingRepository->getTotalTransactions(),
            'totalTransactionsAmount' => $this->serviceBookingRepository->getTotalTransactionsAmount(),
        ];

        return $data;
    }
}
