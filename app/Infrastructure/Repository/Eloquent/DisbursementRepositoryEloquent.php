<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Commons\Exceptions\ClientException;
use App\Domain\Payouts\DisbursementRepository;
use App\Domain\Payouts\Entities\Disbursement as EntitiesDisbursement;
use App\Domain\Payouts\Entities\DisbursementRequest;
use App\Domain\Veterinarians\Entities\VeterinarianShort;
use App\Infrastructure\Repository\Models\Disbursement;
use App\Infrastructure\Repository\Models\User;


class DisbursementRepositoryEloquent implements DisbursementRepository
{
    public function checkIfDisbursementExists($disbursementId)
    {
        $disbursement = Disbursement::find($disbursementId);
        if ($disbursement == null || $disbursement->account_number == null) {
            throw new ClientException("Disbursement not found");
        }
    }

    public function checkBalanceIsEnough($veterinarianId, $amount)
    {
        $balance = User::find($veterinarianId)->walletBalance;
        if ($balance < $amount) {
            throw new ClientException("Insufficient balance");
        }
    }
    public function checkIdempotencyKeyExists($idempotencyKey)
    {
        if (!Disbursement::where('idempotency_key', $idempotencyKey)->exists()) {
            throw new ClientException("Invalid idempotency key");
        }
    }


    public function checkIdempotencyKeyIsUsed($idempotencyKey)
    {
        if (Disbursement::where('idempotency_key', $idempotencyKey)->whereNotNull("account_number")->exists()) {
            throw new ClientException("Idempotency key has already been used");
        }
    }

    public function updateDisbursementStatusByTransferId($transferId, $status, $receiptUrl = null, $failReason = null)
    {
        $disbursement = Disbursement::where('transfer_id', $transferId)->first();

        $disbursement->status = $status;
        if ($status == "DONE") {
            $disbursement->status = "DONE";

            $disbursement->receipt_url = $receiptUrl;
        }
        if ($status == "CANCELLED") {
            User::find($disbursement->veterinarian->id)->pay(($disbursement->amount) * -1, $disbursement->transfer_id);
            $disbursement->status = "FAILED";
            $disbursement->fail_reason = $failReason;
        }
        $disbursement->save();

        return $disbursement;
    }

    public function getIdempotencyKey($veterinarianId)
    {
        $disbursement = Disbursement::where('veterinarian_id', $veterinarianId)->whereNull('account_number')->first();
        if ($disbursement) {
            return $disbursement->idempotency_key;
        }
        $disbursement = new Disbursement();
        $disbursement->idempotency_key = "WITHDRAW_" . now()->format('YmdHis') . rand(1000, 9999);
        $disbursement->veterinarian_id = $veterinarianId;
        $disbursement->save();
        return $disbursement->idempotency_key;
    }

    public function createDisbursement(DisbursementRequest $data, $transfer)
    {
        if ($transfer == null) {
            throw new ClientException("Failed, please try again");
        }
        $disbursement = Disbursement::where('idempotency_key', $data->getIdempotencyKey())->first();
        $disbursement->account_number = $data->getAccountNumber();
        $disbursement->bank_code = $data->getBankCode();
        $disbursement->amount = $data->getAmount();
        $disbursement->remark = $data->getRemark();
        $disbursement->transfer_fee = $transfer['fee'];
        $disbursement->transfer_id = strval($transfer['id']);
        $disbursement->status = "PENDING";
        $disbursement->save();
        User::find($data->getVeterinarianId())->pay($disbursement->amount, $disbursement->transfer_id);
        return $this->createDisbursementEntity(Disbursement::find($disbursement->id));
    }

    public function getDisbursementById($disbursementId)
    {
        $disbursement =  Disbursement::find($disbursementId);
        return $this->createDisbursementEntity($disbursement);
    }

    private function createDisbursementEntity($disbursement)
    {
        $entity = new EntitiesDisbursement(
            $disbursement->id,
            $disbursement->account_number,
            $disbursement->bank_code,
            $disbursement->amount,
            $disbursement->idempotency_key,
            $disbursement->remark,
            new VeterinarianShort(
                $disbursement->veterinarian->data->id,
                $disbursement->veterinarian->data->nameAndTitle(),
                $disbursement->veterinarian->username,
                $disbursement->veterinarian->data->generalIdentity->formalPhoto->file_path,
                $disbursement->veterinarian->data->specializations,
            ),
            $disbursement->status,
            $disbursement->transfer_fee
        );
        if ($disbursement->receipt_url) {
            $entity->setReceiptUrl($disbursement->receipt_url);
        }
        if ($disbursement->fail_reason) {
            $entity->setFailReason($disbursement->fail_reason);
        }
        if ($disbursement->transfer_id) {
            $entity->setTransferId($disbursement->transfer_id);
        }
        return $entity;
    }
    public function getDisbursements()
    {
        return Disbursement::get()->whereNotNull('account_number')->map(function ($disbursement) {
            return $this->createDisbursementEntity($disbursement)->toArray();
        });
    }

    public function checkIfDisbursementValid($transferId)
    {
        $disbursement = Disbursement::where('transfer_id', $transferId)->first();
        if (!$disbursement || $disbursement->transfer_id == null) {
            throw new ClientException("Disbursement not found");
        }
    }

    public function getDisbursementsByVeterinarianId($veterinarianId)
    {
        return Disbursement::where('veterinarian_id', $veterinarianId)->whereNotNull('account_number')->get()->map(function ($disbursement) {
            return $this->createDisbursementEntity($disbursement)->toArray();
        });
    }
}
