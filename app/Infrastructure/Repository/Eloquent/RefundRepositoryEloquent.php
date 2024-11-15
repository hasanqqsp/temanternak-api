<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Domain\Refunds\Entities\NewRefundRequest;
use App\Domain\Refunds\RefundRepository;
use App\Infrastructure\Repository\Models\Refund;

class RefundRepositoryEloquent implements RefundRepository
{
    public function addRequest(NewRefundRequest $refundRequest)
    {
        $refund = new Refund();
        $refund->old_booking_id = $refundRequest->getOldBookingId();
        $refund->new_booking_id = $refundRequest->getNewBookingId();
        $refund->new_service_id = $refundRequest->getNewServiceId();
        $refund->refund_type = $refundRequest->getRefundType();
        $refund->old_transaction_id = $refundRequest->getOldTransactionId();
        $refund->status = $refundRequest->getStatus();
        $refund->save();
    }
}
