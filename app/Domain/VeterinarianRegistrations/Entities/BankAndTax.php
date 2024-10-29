<?php

namespace App\Domain\VeterinarianRegistrations\Entities;

class BankAndTax
{
    private string $npwp;
    private string $npwpFileId;
    private string $bankName;
    private string $bankAccountNumber;
    private string $bankAccountFileId;

    public function __construct(
        string $npwp,
        string $npwpFileId,
        string $bankName,
        string $bankAccountNumber,
        string $bankAccountFileId
    ) {
        $this->npwp = $npwp;
        $this->npwpFileId = $npwpFileId;
        $this->bankName = $bankName;
        $this->bankAccountNumber = $bankAccountNumber;
        $this->bankAccountFileId = $bankAccountFileId;
    }

    public function getNpwp(): string
    {
        return $this->npwp;
    }

    public function setNpwp(string $npwp): void
    {
        $this->npwp = $npwp;
    }

    public function getNpwpFileId(): string
    {
        return $this->npwpFileId;
    }

    public function setNpwpFileId(string $npwpFileId): void
    {
        $this->npwpFileId = $npwpFileId;
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

    public function getBankAccountFileId(): string
    {
        return $this->bankAccountFileId;
    }

    public function setBankAccountFileId(string $bankAccountFileId): void
    {
        $this->bankAccountFileId = $bankAccountFileId;
    }

    public function toArray(): array
    {
        return [
            'npwp' => $this->npwp,
            'npwpFileId' => $this->npwpFileId,
            'bankName' => $this->bankName,
            'bankAccountNumber' => $this->bankAccountNumber,
            'bankAccountFileId' => $this->bankAccountFileId,
        ];
    }
}
