<?php

namespace App\Domain\UserFiles\Entities;

use DateTime;

class UserFile
{
    private string $id;
    private FileOwner $owner;
    private string $httpUrl;
    private string $filename;
    private \DateTime $createdAt;
    private string $documentType;

    public function __construct(
        string $id,
        FileOwner $owner,
        string $httpUrl,
        string $filename,
        string $createdAt,
        string $documentType
    ) {
        $this->id = $id;
        $this->owner = $owner;
        $this->httpUrl = $httpUrl;
        $this->filename = $filename;
        $this->createdAt = new \DateTime($createdAt);
        $this->documentType = $documentType;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getOwner(): FileOwner
    {
        return $this->owner;
    }

    public function setOwner(FileOwner $owner): void
    {
        $this->owner = $owner;
    }

    public function getHttpUrl(): string
    {
        return $this->httpUrl;
    }

    public function setHttpUrl(string $httpUrl): void
    {
        $this->httpUrl = $httpUrl;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): void
    {
        $this->filename = $filename;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt->format(DateTime::ATOM);
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = new DateTime($createdAt);
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
            'id' => $this->getId(),
            'owner' => $this->getOwner()->toArray(), // Assuming FileOwner has a __toString() method or similar
            'httpUrl' => $this->getHttpUrl(),
            'filename' => $this->getFilename(),
            'createdAt' => $this->getCreatedAt(),
            'documentType' => $this->getDocumentType(),
        ];
    }
}
