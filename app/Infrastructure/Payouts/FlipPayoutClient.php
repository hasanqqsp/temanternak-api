<?php

namespace App\Infrastructure\Payouts;

use App\Domain\Payouts\Entities\DisbursementRequest;
use GuzzleHttp\RequestOptions;
use phpDocumentor\Reflection\Types\This;

class FlipPayoutClient
{
    protected $client;
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => env('FLIP_BASE_URL'),
            'headers' => [
                "Authorization" => "Basic " . base64_encode(env('FLIP_API_KEY') . ":")
            ]
        ]);
    }

    public function getBanks()
    {
        $response = $this->client->get('v2/general/banks');
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getBankInfo($bankCode)
    {
        $response = $this->client->get('v2/general/banks?code=' . $bankCode);

        return json_decode($response->getBody()->getContents(), true)[0];
    }


    public function createDisbursement(DisbursementRequest $data, $email)
    {
        $payload = [
            "account_number" => $data->getAccountNumber(),
            "bank_code" => $data->getBankCode(),
            "amount" => $data->getAmount() - $this->getBankInfo($data->getBankCode())['fee'],
            "remark" => "Balance Withdrawal",
            "beneficiary_email" => $email
        ];

        $response = $this->client->post('v3/disbursement', [
            RequestOptions::JSON => $payload,
            RequestOptions::HEADERS => [
                'idempotency-key' => $data->getIdempotencyKey(),
                "Authorization" => "Basic " . base64_encode(env('FLIP_API_KEY') . ":"),
                "Content-Type" => "application/json",
                "Accept" => "application/json"
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
