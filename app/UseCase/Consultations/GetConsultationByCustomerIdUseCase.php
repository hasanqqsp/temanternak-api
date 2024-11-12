<?php

namespace App\UseCase\Consultations;

use App\Domain\Consultations\ConsultationRepository;

class GetConsultationByCustomerIdUseCase
{
    private $consultationRepository;

    public function __construct(ConsultationRepository $consultationRepository)
    {
        $this->consultationRepository = $consultationRepository;
    }

    public function execute(string $customerId)
    {
        return $this->consultationRepository->getAllByCustomerId($customerId);
    }
}
