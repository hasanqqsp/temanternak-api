<?php

namespace App\Domain\Payouts\Entities;

use App\Domain\Veterinarians\Entities\VeterinarianShort;

class Disbursement
{
    private string $id;
    private string $account_number;
    private string $bank_code;
    private float $amount;
    private string $remark;
    private string $idempotencyKey;
    private VeterinarianShort $veterinarian;
    private ?string $receiptUrl = null;
    private ?string $failReason = null;
    private ?string $transferId = null;

    public function __construct(string $id, string $account_number, string $bank_code, float $amount, string $remark, string $idempotencyKey, VeterinarianShort $veterinarian, ?string $receiptUrl = null, ?string $failReason = null, ?string $transferId = null)
    {
        $this->id = $id;
        $this->account_number = $account_number;
        $this->bank_code = $bank_code;
        $this->amount = $amount;
        $this->remark = $remark;
        $this->idempotencyKey = $idempotencyKey;
        $this->veterinarian = $veterinarian;
        $this->receiptUrl = $receiptUrl;
        $this->failReason = $failReason;
        $this->transferId = $transferId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getAccountNumber(): string
    {
        return $this->account_number;
    }

    public function setAccountNumber(string $account_number): void
    {
        $this->account_number = $account_number;
    }

    public function getBankCode(): string
    {
        return $this->bank_code;
    }

    public function setBankCode(string $bank_code): void
    {
        $this->bank_code = $bank_code;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getRemark(): string
    {
        return $this->remark;
    }

    public function setRemark(string $remark): void
    {
        $this->remark = $remark;
    }

    public function getIdempotencyKey(): string
    {
        return $this->idempotencyKey;
    }

    public function setIdempotencyKey(string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    public function getVeterinarian(): VeterinarianShort
    {
        return $this->veterinarian;
    }

    public function setVeterinarian(VeterinarianShort $veterinarian): void
    {
        $this->veterinarian = $veterinarian;
    }

    public function getReceiptUrl(): ?string
    {
        return $this->receiptUrl;
    }

    public function setReceiptUrl(?string $receiptUrl): void
    {
        $this->receiptUrl = $receiptUrl;
    }

    public function getFailReason(): ?string
    {
        return $this->failReason;
    }

    public function setFailReason(?string $failReason): void
    {
        $this->failReason = $failReason;
    }

    public function getTransferId(): ?string
    {
        return $this->transferId;
    }

    public function setTransferId(?string $transferId): void
    {
        $this->transferId = $transferId;
    }

    public function toArray(): array
    {
        $data = [
            'id' => $this->id,
            'account_number' => $this->account_number,
            'bank_code' => $this->bank_code,
            'amount' => $this->amount,
            'remark' => $this->remark,
            'idempotencyKey' => $this->idempotencyKey,
            'veterinarian' => $this->veterinarian->toArray(),
        ];

        if ($this->receiptUrl !== null) {
            $data['receiptUrl'] = $this->receiptUrl;
        }

        if ($this->failReason !== null) {
            $data['failReason'] = $this->failReason;
        }

        if ($this->transferId !== null) {
            $data['transferId'] = $this->transferId;
        }

        return $data;
    }
}
