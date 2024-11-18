<?php

namespace App\Domain\Payouts;

use App\Domain\Payouts\Entities\DisbursementRequest;

interface DisbursementRepository
{
    public function createDisbursement(DisbursementRequest $data, $transferId);
    public function getDisbursementById($disbursementId);
    public function getDisbursements();
    public function getDisbursementsByVeterinarianId($veterinarianId);
    public function updateDisbursementStatusByTransferId($disbursementId, $status, $receiptUrl);
    public function getIdempotencyKey($veterinarianId);
    public function checkIdempotencyKeyExists($idempotencyKey);
    public function checkIdempotencyKeyIsUsed($idempotencyKey);
    public function checkBalanceIsEnough($veterinarianId, $amount);
    public function checkIfDisbursementValid($transferId);
    public function checkIfDisbursementExists($disbursementId);
}
