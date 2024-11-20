<?php

namespace App\Domain\Consultations;

use App\Domain\Consultations\Entities\Consultation;
use App\Domain\Consultations\Entities\ConsultationShort;

interface ConsultationRepository
{
    public function populate(string $bookingId);
    public function updateStatusByBookingId($bookingId, $status);
    public function getByBookingId($id): ConsultationShort;
    public function getAllByVeterinarianId($veterinarianId): array;
    public function getAllByStatusAndVeterinarianId($status, $veterinarianId): array;
    public function getAllByCustomerId($customerId): array;
    public function checkIfExists($bookingId);
    public function joinConsultation($role, $bookingId);
    public function addResult($bookingId, $result);
    public function getDetail($bookingId): Consultation;
    public function addReport($bookingId, $reportFilePath);
    public function getReport($bookingId);
}
