<?php

namespace App\UseCase\ServiceBooking;

use App\Commons\Exceptions\ClientException;
use App\Domain\Refunds\Entities\NewRefundRequest;
use App\Domain\Refunds\Entities\RefundRequest;
use App\Domain\Refunds\RefundRepository;
use App\Domain\ServiceBookings\Entities\NewBooking;
use App\Domain\ServiceBookings\ServiceBookingRepository;
use App\Domain\Transactions\Entities\NewTransaction;
use App\Domain\Transactions\TransactionRepository;
use App\Infrastructure\Payment\MidtransPaymentGateway;
use App\Infrastructure\Repository\Models\Refund;
use Carbon\Carbon;

class RefundServiceBookingUseCase
{
    private $bookingRepository;
    private $transactionRepository;
    private $midtransPaymentGateway;

    public function __construct(ServiceBookingRepository $bookingRepository, TransactionRepository $transactionRepository, MidtransPaymentGateway $midtransPaymentGateway)
    {
        $this->bookingRepository = $bookingRepository;
        $this->transactionRepository = $transactionRepository;
        $this->midtransPaymentGateway = $midtransPaymentGateway;
    }

    public function execute(string $bookingId, string $credentialId)
    {
        $this->bookingRepository->checkIfExists($bookingId);
        $this->bookingRepository->checkIfAuthorized($bookingId, $credentialId);
        $this->bookingRepository->checkIsRefundable($bookingId);
        $booking = $this->bookingRepository->getById($bookingId);
        $transaction = $booking->getTransaction();

        try {
            $this->midtransPaymentGateway->refundTransaction($transaction->getId(), [
                'amount' => $transaction->getPrice(),
                'reason' => 'Booking failed'
            ]);
        } catch (\Exception $e) {
            // $this->transactionRepository->manualCancel($transaction->getId());
            $this->bookingRepository->cancel($booking->getId(), $credentialId);

            throw new ClientException("Payment gateway reject to refund transaction : " . $e->getMessage());
        }

        $this->bookingRepository->cancel($booking->getId(), $credentialId);
    }
}
