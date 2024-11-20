<?php

namespace App\UseCase\Payouts;

use App\Domain\Payouts\DisbursementRepository;

class UpdateDisbursementStatusByTransferIdUseCase
{
    private $disbursementRepository;

    public function __construct(DisbursementRepository $disbursementRepository)
    {
        $this->disbursementRepository = $disbursementRepository;
    }

    public function execute(string $transferId, string $status, ?string $receiptUrl, ?string $failReason)
    {
        $this->disbursementRepository->checkIfDisbursementValid($transferId);
        return $this->disbursementRepository->updateDisbursementStatusByTransferId($transferId, $status, $receiptUrl, $failReason);
    }
}
