<?php

namespace App\UseCase\Consultations;

use App\Domain\Consultations\ConsultationRepository;

class GetConsultationByVeterinarianIdUseCase
{
    private $consultationRepository;

    public function __construct(ConsultationRepository $consultationRepository)
    {
        $this->consultationRepository = $consultationRepository;
    }

    public function execute(string $veterinarianId)
    {
        return $this->consultationRepository->getAllByVeterinarianId($veterinarianId);
    }
}
