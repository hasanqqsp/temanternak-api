<?php

namespace App\Domain\Consultations;

use App\Domain\Consultations\Entities\Consultation;

interface ConsultationRepository
{
    public function populate(string $bookingId);
    public function updateStatusByBookingId($bookingId, $status);
    public function getByBookingId($id): Consultation;
    public function getAll(): array;
    public function getAllByStatus($status): array;
    public function getAllByVeterinarianId($veterinarianId): array;
    public function getAllByStatusAndVeterinarianId($status, $veterinarianId): array;
    public function getAllByCustomerId($customerId): array;
    public function checkIfExists($bookingId);
    public function joinConsultation($role, $bookingId);
}
