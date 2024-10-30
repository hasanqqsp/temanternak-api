<?php

namespace App\Domain\VeterinarianRegistrations\Entities;

class BankAndTaxResponse
{
    private string $npwp;
    private string $npwpFilePath;
    private string $bankName;
    private string $bankAccountNumber;
    private string $bankAccountFilePath;
    private string $bankAccountName;

    public function __construct(
        string $npwp,
        string $npwpFilePath,
        string $bankName,
        string $bankAccountNumber,
        string $bankAccountFilePath,
        string $bankAccountName
    ) {
        $this->npwp = $npwp;
        $this->npwpFilePath = $npwpFilePath;
        $this->bankName = $bankName;
        $this->bankAccountNumber = $bankAccountNumber;
        $this->bankAccountFilePath = $bankAccountFilePath;
        $this->bankAccountName = $bankAccountName;
    }

    public function getNpwp(): string
    {
        return $this->npwp;
    }

    public function setNpwp(string $npwp): void
    {
        $this->npwp = $npwp;
    }

    public function getNpwpFilePath(): string
    {
        return $this->npwpFilePath;
    }

    public function setNpwpFilePath(string $npwpFilePath): void
    {
        $this->npwpFilePath = $npwpFilePath;
    }

    public function getBankName(): string
    {
        return $this->bankName;
    }

    public function setBankName(string $bankName): void
    {
        $this->bankName = $bankName;
    }

    public function getBankAccountNumber(): string
    {
        return $this->bankAccountNumber;
    }

    public function setBankAccountNumber(string $bankAccountNumber): void
    {
        $this->bankAccountNumber = $bankAccountNumber;
    }

    public function getBankAccountFilePath(): string
    {
        return $this->bankAccountFilePath;
    }

    public function setBankAccountFilePath(string $bankAccountFilePath): void
    {
        $this->bankAccountFilePath = $bankAccountFilePath;
    }

    public function getBankAccountName(): string
    {
        return $this->bankAccountName;
    }

    public function setBankAccountName(string $bankAccountName): void
    {
        $this->bankAccountName = $bankAccountName;
    }

    public function toArray(): array
    {
        return [
            'npwp' => $this->npwp,
            'npwpFilePath' => $this->npwpFilePath,
            'bankName' => $this->bankName,
            'bankAccountNumber' => $this->bankAccountNumber,
            'bankAccountFilePath' => $this->bankAccountFilePath,
            'bankAccountName' => $this->bankAccountName,
        ];
    }
}
