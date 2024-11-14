<?php

namespace App\UseCase\Transactions;

use App\Domain\ServiceBookings\ServiceBookingRepository;
use App\Domain\Transactions\TransactionRepository;

class ChangeTransactionStatusById
{
    protected $transactionRepository;
    protected $serviceBookingRepository;

    public function __construct(TransactionRepository $transactionRepository, ServiceBookingRepository $serviceBookingRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->serviceBookingRepository = $serviceBookingRepository;
    }

    public function execute(string $transactionId, string $newStatus, $paymentType)
    {
        if (!in_array($newStatus, ['PENDING', 'PAID', 'DENIED', "EXPIRED", "CANCELLED", "REFUNDED"])) {
            throw new \InvalidArgumentException('Invalid status provided');
        }
        $this->transactionRepository->checkIfExist($transactionId);
        if ($newStatus == "PAID") {
            $this->transactionRepository->updateStatus($transactionId, $newStatus);
            $this->serviceBookingRepository->updateStatusByTransactionId($transactionId, "CONFIRMED", $paymentType);
        } else if (in_array($newStatus, ['DENIED', "EXPIRED", "CANCELLED", "REFUNDED"])) {
            $this->transactionRepository->updateStatus($transactionId, $newStatus);
            $this->serviceBookingRepository->updateStatusByTransactionId($transactionId, "CANCELLED", $paymentType);
        } else {
            $this->transactionRepository->updateStatus($transactionId, $newStatus);
            $this->serviceBookingRepository->updateStatusByTransactionId($transactionId, "PENDING", $paymentType);
        }
    }
}
