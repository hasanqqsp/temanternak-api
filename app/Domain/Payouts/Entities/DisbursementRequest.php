<?php

namespace App\Domain\Payouts\Entities;

class DisbursementRequest
{
    private $account_number;
    private $bank_code;
    private $amount;
    private $idempotencyKey;
    private $veterinarianId;
    private $remark;

    public function __construct($account_number, $bank_code, $amount, $idempotencyKey, $veterinarianId, $remark)
    {
        $this->account_number = $account_number;
        $this->bank_code = $bank_code;
        $this->amount = $amount;
        $this->idempotencyKey = $idempotencyKey;
        $this->veterinarianId = $veterinarianId;
        $this->remark = $remark;
    }

    public function getAccountNumber()
    {
        return $this->account_number;
    }

    public function setAccountNumber($account_number)
    {
        $this->account_number = $account_number;
    }

    public function getBankCode()
    {
        return $this->bank_code;
    }

    public function setBankCode($bank_code)
    {
        $this->bank_code = $bank_code;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getIdempotencyKey()
    {
        return $this->idempotencyKey;
    }

    public function setIdempotencyKey($idempotencyKey)
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    public function getVeterinarianId()
    {
        return $this->veterinarianId;
    }

    public function setVeterinarianId($veterinarianId)
    {
        $this->veterinarianId = $veterinarianId;
    }

    public function getRemark()
    {
        return $this->remark;
    }

    public function setRemark($remark)
    {
        $this->remark = $remark;
    }

    public function toArray()
    {
        return [
            'account_number' => $this->account_number,
            'bank_code' => $this->bank_code,
            'amount' => $this->amount,
            'idempotencyKey' => $this->idempotencyKey,
            'veterinarianId' => $this->veterinarianId,
            'remark' => $this->remark,
        ];
    }
}
