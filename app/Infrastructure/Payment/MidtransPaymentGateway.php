<?php

namespace App\Infrastructure\Payment;

use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransPaymentGateway
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = (bool) env('MIDTRANS_IS_PRODUCTION');
        \Midtrans\Config::$isSanitized = (bool) env('MIDTRANS_IS_SANITIZED');
        \Midtrans\Config::$is3ds = (bool) env('MIDTRANS_IS_3DS');
    }
    public function getSnapToken($data)
    {
        return Snap::getSnapToken($data);
    }

    public function cancelTransaction($transactionId)
    {
        return Transaction::cancel($transactionId);
    }

    public static function createPayload($transactionId, $paymentAmount, $products, $name, $email, $orderTime, $expiry)
    {
        return [
            "transaction_details" => [
                "order_id" => $transactionId,
                "gross_amount" => $paymentAmount,
            ],
            "credit_card" => [
                "secure" => true
            ],
            "item_details" => $products,
            "customer_details" => [
                "first_name" => $name,
                "email" => $email,
            ],
            "expiry" => [
                "start_time" => $orderTime,
                "duration" => $expiry,
                "unit" => "minutes"
            ]
        ];
    }
}
