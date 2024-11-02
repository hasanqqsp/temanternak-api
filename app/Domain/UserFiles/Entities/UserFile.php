<?php

namespace App\Domain\UserFiles\Entities;

class UserFile
{
    private string $id;
    private FileOwner $owner;
    private string $httpUrl;
    private string $pathname;
    private string $createdAt;
    private string $documentType;

    public function __construct(
        string $id,
        FileOwner $owner,
        string $httpUrl,
        string $pathname,
        string $createdAt,
        string $documentType
    ) {
        $this->id = $id;
        $this->owner = $owner;
        $this->httpUrl = $httpUrl;
        $this->pathname = $pathname;
        $this->createdAt = $createdAt;
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

    public function getPathname(): string
    {
        return $this->pathname;
    }

    public function setPathname(string $pathname): void
    {
        $this->pathname = $pathname;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
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
            'owner' => $this->getOwner()->toArray(), // Assuming FileOwner has a toArray() method or similar
            'httpUrl' => $this->getHttpUrl(),
            'pathname' => $this->getPathname(),
            'createdAt' => $this->getCreatedAt(),
            'documentType' => $this->getDocumentType(),
        ];
    }
}
