<?php

namespace App\UseCase\Consultations;

use App\Domain\Consultations\ConsultationRepository;
use App\Domain\ServiceBookings\ServiceBookingRepository;

class GetConsultationDetailByBookingIdUseCase
{
    protected $consultationRepository;
    protected $bookingRepository;

    public function __construct(ConsultationRepository $consultationRepository, ServiceBookingRepository $bookingRepository)
    {
        $this->consultationRepository = $consultationRepository;
        $this->bookingRepository = $bookingRepository;
    }

    public function execute($bookingId, $credentialId)
    {
        $this->bookingRepository->checkIfExists($bookingId);
        $this->bookingRepository->checkIfAuthorized($bookingId, $credentialId);
        return $this->consultationRepository->getDetail($bookingId);
    }
}
