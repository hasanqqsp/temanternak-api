<?php

namespace App\Interfaces\Http\Controller;

use App\Infrastructure\Payouts\FlipPayoutClient;
use Illuminate\Routing\Controller;

class PayoutsController extends Controller
{
    protected $flipPayoutClient;
    public function __construct()
    {
        $this->flipPayoutClient = new FlipPayoutClient();
    }

    public function getBanks()
    {
        $banks = $this->flipPayoutClient->getBanks();
        return response()->json([
            "status" => "success",
            "data" => $banks
        ]);
    }
}
