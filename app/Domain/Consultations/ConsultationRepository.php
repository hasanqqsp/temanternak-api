<?php

use App\Domain\Consultations\Entities\Consultation;
use App\Domain\Consultations\Entities\NewConsultation;

interface ConsultationRepository
{
    public function add(NewConsultation $consultation);
    public function updateStatusById($id, $status);
    public function getById($id): Consultation;
    public function getAll(): array;
    public function getAllByStatus($status): array;
    public function getAllByVeterinarianId($veterinarianId): array;
    public function getAllByStatusAndVeterinarianId($status, $veterinarianId): array;
}
