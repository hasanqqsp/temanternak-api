<?php

namespace App\UseCase\Payouts;

use App\Domain\Payouts\DisbursementRepository;

class GetDisbursementByVeterinarianIdUseCase
{
    private $disbursementRepository;

    public function __construct(DisbursementRepository $disbursementRepository)
    {
        $this->disbursementRepository = $disbursementRepository;
    }

    public function execute(string $veterinarianId)
    {
        return $this->disbursementRepository->getDisbursementsByVeterinarianId($veterinarianId);
    }
}
