<?php

namespace App\Domain\Transactions\Entities;

use App\Domain\Users\Entities\ShortUser;

class Transaction
{
    private $id;
    private $price;
    private $platformFee;
    private ShortUser $customer;
    private $products;
    private $paymentToken;
    private $status;

    public function __construct($id, $price, $platformFee, ShortUser $customer, $products, $paymentToken, $status)
    {
        $this->id = $id;
        $this->price = $price;
        $this->platformFee = $platformFee;
        $this->customer = $customer;
        $this->products = $products;
        $this->paymentToken = $paymentToken;
        $this->status = $status;
    }

    // Getters and setters for each attribute can be added here

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getPlatformFee()
    {
        return $this->platformFee;
    }

    public function setPlatformFee($platformFee)
    {
        $this->platformFee = $platformFee;
    }

    public function getCustomer(): ShortUser
    {
        return $this->customer;
    }

    public function setCustomer(ShortUser $customer)
    {
        $this->customer = $customer;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function setProducts($products)
    {
        $this->products = $products;
    }

    public function getPaymentToken()
    {
        return $this->paymentToken;
    }

    public function setPaymentToken($paymentToken)
    {
        $this->paymentToken = $paymentToken;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'platformFee' => $this->platformFee,
            'customer' => $this->customer->toArray(),
            'products' => $this->products,
            'paymentToken' => $this->paymentToken,
            'status' => $this->status,
        ];
    }
}
