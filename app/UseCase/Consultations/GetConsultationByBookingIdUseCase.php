<?php

namespace App\UseCase\Consultations;

use App\Commons\Exceptions\NotFoundException;
use App\Domain\Consultations\ConsultationRepository;
use App\Domain\ServiceBookings\ServiceBookingRepository;

class GetConsultationByBookingIdUseCase
{
    private $consultationRepository;
    private $bookingRepository;

    public function __construct(ConsultationRepository $consultationRepository, ServiceBookingRepository $bookingRepository)
    {
        $this->consultationRepository = $consultationRepository;
        $this->bookingRepository = $bookingRepository;
    }

    public function execute(string $bookingId, string $credentialId)
    {
        $this->bookingRepository->checkIfAuthorized($bookingId, $credentialId);
        $booking =  $this->bookingRepository->getById($bookingId);
        if ($booking->getStatus() !== 'CONFIRMED') {
            throw new NotFoundException('Consultation not found');
        }
        try {
            $this->consultationRepository->checkIfExists($bookingId);
        } catch (NotFoundException $e) {
            $this->consultationRepository->populate($bookingId);
        }
        return $this->consultationRepository->getByBookingId($bookingId);
    }
}
