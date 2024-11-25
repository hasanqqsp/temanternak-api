<?php

namespace App\Domain\Payouts\Entities;

class TransferDetail
{
    private $amount;
    private $bank_code;
    private $status;

    public function __construct($amount, $bank_code, $status)
    {
        $this->amount = $amount;
        $this->bank_code = $bank_code;
        $this->status = $status;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getBankCode()
    {
        return $this->bank_code;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function setBankCode($bank_code)
    {
        $this->bank_code = $bank_code;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function toArray()
    {
        return [
            'amount' => $this->amount,
            'bank_code' => $this->bank_code,
            'status' => $this->status,
        ];
    }
}
