<?php

namespace App\UseCase\Consultations;

use App\Domain\Consultations\ConsultationRepository;
use App\Domain\ServiceBookings\ServiceBookingRepository;

class AddConsultationResultByBookingIdUseCase
{
    private $consultationRepository;
    private $bookingRepository;

    public function __construct(ConsultationRepository $consultationRepository, ServiceBookingRepository $bookingRepository)
    {
        $this->consultationRepository = $consultationRepository;
        $this->bookingRepository = $bookingRepository;
    }

    public function execute(string $bookingId, string $consultationResult, $credentialId)
    {
        $this->bookingRepository->checkIfExists($bookingId);
        $this->bookingRepository->checkIfAuthorized($bookingId, $credentialId);
        return $this->consultationRepository->addResult($bookingId, $consultationResult);
    }
}
