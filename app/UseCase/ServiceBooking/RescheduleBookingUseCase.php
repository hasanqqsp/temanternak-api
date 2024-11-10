<?php

namespace App\UseCase\ServiceBooking;

use App\Commons\Exceptions\ClientException;
use App\Domain\ServiceBookings\ServiceBookingRepository;
use App\Domain\VeterinarianSchedules\VeterinarianScheduleRepository;
use DateTime;

class RescheduleBookingUseCase
{
    protected $serviceBookingRepository;
    protected $veterinarianScheduleRepository;

    public function __construct(ServiceBookingRepository $serviceBookingRepository, VeterinarianScheduleRepository $veterinarianScheduleRepository)
    {
        $this->serviceBookingRepository = $serviceBookingRepository;
        $this->veterinarianScheduleRepository = $veterinarianScheduleRepository;
    }
    public function execute(string $bookingId, string $newStartTime, $credentialId)
    {
        $this->serviceBookingRepository->checkIfExists($bookingId);
        $this->serviceBookingRepository->checkIfAuthorized($bookingId, $credentialId);
        $booking = $this->serviceBookingRepository->getById($bookingId);
        if ($booking->getStartTime() < now()->addHours(1)) {
            throw new ClientException("You can only cancel booking 1 hours before the schedule");
        }
        $status = $booking->getStatus();
        if ($status === 'CANCELLED') {
            throw new ClientException('Booking is already cancelled');
        }

        $this->veterinarianScheduleRepository->checkIfTimeIsAvailableForReschedule($bookingId, new DateTime($newStartTime));
        $this->serviceBookingRepository->reschedule($bookingId, $newStartTime);
    }
}
