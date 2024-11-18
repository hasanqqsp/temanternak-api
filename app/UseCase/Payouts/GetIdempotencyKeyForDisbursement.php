<?php

namespace App\UseCase\Payouts;

use App\Domain\Payouts\DisbursementRepository;

class GetIdempotencyKeyForDisbursement
{
    private $disbursementRepository;
    public function __construct(DisbursementRepository $disbursementRepository)
    {
        $this->disbursementRepository = $disbursementRepository;
    }

    public function execute(string $veterinarianId): string
    {
        return $this->disbursementRepository->getIdempotencyKey($veterinarianId);
    }
}
