<?php

namespace App\Domain\Transactions\Entities;

use Hidehalo\Nanoid\Client;

class NewTransaction
{
    private string $id;
    private float $price;
    private float $platformFee;
    private string $customerId;
    private array $products;
    private string $paymentToken;

    public function __construct(float $price, float $platformFee, string $customerId, array $products)
    {
        $this->id = "TRX-" . now()->format('Ymd') . "-" . (new Client())->generateId($size = 8);
        $this->price = $price;
        $this->platformFee = $platformFee;
        $this->customerId = $customerId;
        $this->products = $products;
    }

    // Getters and setters for each attribute can be added here

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(): void
    {
        $this->id = "TRX-" . now()->format('Ymd') . "-" . (new Client())->generateId($size = 8);
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getPlatformFee(): float
    {
        return $this->platformFee;
    }

    public function setPlatformFee(float $platformFee): void
    {
        $this->platformFee = $platformFee;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function setCustomerId(string $customerId): void
    {
        $this->customerId = $customerId;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    public function getPaymentToken(): string
    {
        return $this->paymentToken;
    }

    public function setPaymentToken(string $paymentToken): void
    {
        $this->paymentToken = $paymentToken;
    }
}
