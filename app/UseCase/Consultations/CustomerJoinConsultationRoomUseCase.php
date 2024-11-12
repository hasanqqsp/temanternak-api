<?php

namespace App\UseCase\Consultations;

use App\Domain\Consultations\ConsultationRepository;
use App\Domain\ServiceBookings\ServiceBookingRepository;
use App\Domain\Users\UserRepository;


class CustomerJoinConsultationRoomUseCase
{
    protected $userRepository;
    protected $serviceBookingRepository;
    protected $consultationRepository;

    public function __construct(
        UserRepository $userRepository,
        ServiceBookingRepository $serviceBookingRepository,
        ConsultationRepository $consultationRepository
    ) {
        $this->userRepository = $userRepository;
        $this->serviceBookingRepository = $serviceBookingRepository;
        $this->consultationRepository = $consultationRepository;
    }

    public function execute($bookingId, $credentialId)
    {
        $this->serviceBookingRepository->checkIfExists($bookingId);
        $this->serviceBookingRepository->checkIfAuthorized($bookingId, $credentialId);
        $this->consultationRepository->joinConsultation('customer', $bookingId);
    }
}
