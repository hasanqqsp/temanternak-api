<?php

namespace App\UseCase\ServiceBooking;

use App\Commons\Exceptions\ClientException;
use App\Domain\ServiceBookings\ServiceBookingRepository;
use App\Domain\Transactions\TransactionRepository;
use App\Infrastructure\Payment\MidtransPaymentGateway;

class CancelServiceBookingUseCase
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
        $booking = $this->bookingRepository->getById($bookingId);
        $status = $booking->getStatus();
        $transaction = $booking->getTransaction();

        if ($booking->getStartTime() < now()->addHours(1)) {
            throw new ClientException("You can only cancel booking 1 hours before the schedule");
        }
        if ($status === 'CANCELLED') {
            throw new ClientException("Booking already cancelled");
        }
        if ($status === 'CONFIRMED') {
            try {
                $this->midtransPaymentGateway->refundTransaction($transaction->getId(), [
                    'amount' => $transaction->getPrice(),
                    'reason' => 'Booking cancellation'
                ]);
            } catch (\Exception $e) {
                // $this->transactionRepository->manualCancel($transaction->getId());
                $this->bookingRepository->cancel($booking->getId(), $credentialId);

                throw new ClientException("Payment gateway reject to refund transaction : " . $e->getMessage());
            }
        }
        if ($status === 'ONPROGRESS') {
            throw new ClientException("Booking already confirmed");
        }
        if ($status === 'COMPLETED') {
            throw new ClientException("Booking already completed");
        }

        try {
            $this->midtransPaymentGateway->cancelTransaction($transaction->getId());
        } catch (\Exception $e) {
            $this->transactionRepository->manualCancel($transaction->getId());
        }

        $this->bookingRepository->cancel($booking->getId(), $credentialId);
    }
}
