<?php

namespace App\UseCase\Payouts;

use App\Domain\Payouts\DisbursementRepository;

class GetAllDisbursementRequestUseCase
{
    private $disbursementRepository;

    public function __construct(DisbursementRepository $disbursementRepository)
    {
        $this->disbursementRepository = $disbursementRepository;
    }

    public function execute()
    {
        return $this->disbursementRepository->getDisbursements();
    }
}
