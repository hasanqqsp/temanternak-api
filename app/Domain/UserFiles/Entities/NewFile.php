<?php

namespace App\Domain\UserFiles\Entities;

class NewFile
{
    private string $userId;
    private string $filePath;
    private string $documentType;

    public function __construct(string $userId, string $filePath, string $documentType)
    {
        $this->userId = $userId;
        $this->filePath = $filePath;
        $this->documentType = $documentType;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }

    public function getDocumentType(): string
    {
        return $this->documentType;
    }

    public function setDocumentType(string $documentType): void
    {
        $this->documentType = $documentType;
    }

    public function toArray(): array
    {
        return [
            'userId' => $this->userId,
            'filePath' => $this->filePath,
            'documentType' => $this->documentType,
        ];
    }
}
