<?php

namespace App\Domain\Wallets\Entities;

use App\Domain\Consultations\Entities\ConsultationShort;
use App\Domain\Payouts\Entities\TransferDetail;

class WalletLogItem
{
    private string $id;
    private string $from;
    private string $to;
    private float $price;
    private float $platformFee;
    private float $acceptedAmount;
    private ?ConsultationShort $consultation;
    private \DateTime $timestamp;
    private ?TransferDetail $transferDetail;

    public function __construct(
        string $id,
        string $from,
        string $to,
        float $price,
        float $platformFee,
        float $acceptedAmount,
        ?ConsultationShort $consultation,
        \DateTime $timestamp,
        ?TransferDetail $transferDetail
    ) {
        $this->id = $id;
        $this->from = $from;
        $this->to = $to;
        $this->price = $price;
        $this->platformFee = $platformFee;
        $this->acceptedAmount = $acceptedAmount;
        $this->consultation = $consultation;
        $this->timestamp = $timestamp;
        $this->transferDetail = $transferDetail;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getPlatformFee(): float
    {
        return $this->platformFee;
    }

    public function getAcceptedAmount(): float
    {
        return $this->acceptedAmount;
    }

    public function getConsultation(): ?ConsultationShort
    {
        return $this->consultation;
    }

    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }

    public function getTransferDetail(): TransferDetail
    {
        return $this->transferDetail;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setFrom(string $from): void
    {
        $this->from = $from;
    }

    public function setTo(string $to): void
    {
        $this->to = $to;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function setPlatformFee(float $platformFee): void
    {
        $this->platformFee = $platformFee;
    }

    public function setAcceptedAmount(float $acceptedAmount): void
    {
        $this->acceptedAmount = $acceptedAmount;
    }

    public function setConsultation(?ConsultationShort $consultation): void
    {
        $this->consultation = $consultation;
    }

    public function setTimestamp(\DateTime $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    public function setTransferDetail(TransferDetail $transferDetail): void
    {
        $this->transferDetail = $transferDetail;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'from' => $this->from,
            'to' => $this->to,
            'price' => $this->price,
            'platformFee' => $this->platformFee,
            'acceptedAmount' => $this->acceptedAmount,
            'consultation' => $this->consultation ? $this->consultation->toArray() : null,
            'timestamp' => $this->timestamp->format('Y-m-d\TH:i:s.up'),
            'transferDetail' => $this->transferDetail ? $this->transferDetail->toArray() : null,
        ];
    }
}
