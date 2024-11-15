<?php

namespace App\Domain\Refunds;

use App\Domain\Refunds\Entities\NewRefundRequest;

interface RefundRepository
{
    public function addRequest(NewRefundRequest $refundRequest);
}
