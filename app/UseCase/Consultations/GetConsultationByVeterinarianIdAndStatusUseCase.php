<?php

namespace App\UseCase\Consultations;

use App\Domain\Consultations\ConsultationRepository;

class GetConsultationByVeterinarianIdAndStatusUseCase
{
    protected $consultationRepository;

    public function __construct(ConsultationRepository $consultationRepository)
    {
        $this->consultationRepository = $consultationRepository;
    }

    public function execute(string $veterinarianId, string $status)
    {
        return $this->consultationRepository->getAllByStatusAndVeterinarianId($veterinarianId, $status);
    }
}
