<?php

namespace App\UseCase\Payouts;

use App\Domain\Payouts\DisbursementRepository;

class GetDisbursementRequestByIdUseCase
{
    private $disbursementRepository;

    public function __construct(DisbursementRepository $disbursementRepository)
    {
        $this->disbursementRepository = $disbursementRepository;
    }

    public function execute(string $id)
    {
        return $this->disbursementRepository->getDisbursementById($id);
    }
}
