<?php

namespace App\Infrastructure\Payouts;


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
}
