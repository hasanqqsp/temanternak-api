<?php

namespace App\UseCase\ServiceBooking;

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

class RebookServiceBookingUseCase
{
    protected $serviceBookingRepository;
    protected $midtransPaymentGateway;
    protected $refundRepository;
    protected $transactionRepository;

    public function __construct(
        ServiceBookingRepository $serviceBookingRepository,
        MidtransPaymentGateway $midtransPaymentGateway,
        RefundRepository $refundRepository,
        TransactionRepository $transactionRepository
    ) {
        $this->serviceBookingRepository = $serviceBookingRepository;
        $this->midtransPaymentGateway = $midtransPaymentGateway;
        $this->refundRepository = $refundRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function execute(NewRefundRequest $requestRefund, $credentialId)
    {
        $this->serviceBookingRepository->checkIfExists($requestRefund->getOldBookingId());
        $this->serviceBookingRepository->checkIfAuthorized($requestRefund->getOldBookingId(), $credentialId);
        $this->serviceBookingRepository->checkIsRefundable($requestRefund->getOldBookingId());

        $newBooking = $this->serviceBookingRepository->add(new NewBooking(
            $requestRefund->getNewServiceId(),
            $requestRefund->getStartTime()->format('Y-m-d\TH:i:s.up'),
            $requestRefund->getBookerId(),
            $requestRefund->getVeterinarianId()
        ));

        $this->serviceBookingRepository->setRebookingId($requestRefund->getOldBookingId(), $newBooking->getId());
        $oldBooking = $this->serviceBookingRepository->getById($requestRefund->getOldBookingId());
        if ($oldBooking->getService()->getPrice() == $newBooking->getService()->getPrice()) {
            $newBooking->setTransactionId($oldBooking->getTransaction()->getId());
            return new Refund(
                $oldBooking->getId(),
                $newBooking->getService()->getId(),
                RefundRequest::$REFUND_TYPE["REBOOK_WITHOUT_REFUND"],
                "SUCCESS",
                $newBooking,
            );
        } else if ($oldBooking->getService()->getPrice() < $newBooking->getService()->getPrice()) {
            $this->midtransPaymentGateway->refund($oldBooking->getTransaction()->getId(), $oldBooking->getService()->getPrice() - $newBooking->getService()->getPrice());
            $newBooking->setTransactionId($oldBooking->getTransaction()->getId());
            return new Refund(
                $oldBooking->getId(),
                $newBooking->getService()->getId(),
                RefundRequest::$REFUND_TYPE["REBOOK_WITH_REFUND"],
                "SUCCESS",
                $newBooking,
            );
        } else if ($oldBooking->getService()->getPrice() > $newBooking->getService()->getPrice()) {
            $products = [
                'id' => 1,
                'name' => $oldBooking->getService()->getName() . 'Price difference',
                'price' => $newBooking->getPrice() - $oldBooking->getPrice(),
                'quantity' => 1
            ];

            $newTransaction = new NewTransaction(
                $newBooking->getPrice() - $oldBooking->getPrice(),
                $newBooking->getService()->getPrice()  * 0.15,
                $newBooking->getBookerId(),
                $products
            );
            $payment = $this->midtransPaymentGateway->getSnapToken(MidtransPaymentGateway::createPayload(
                $newTransaction->getId(),
                $newTransaction->getPrice(),
                $products,
                $newBooking->getBooker()->getName(),
                $newBooking->getBooker()->getEmail(),
                now()->format("Y-m-d H:i:s +Z"),
                floor(min([(new Carbon($newBooking->getStartTime()))->subMinute()->diffInMinutes(now()) * -1, 60]))
            ));

            $this->serviceBookingRepository->setTransactionId($newBooking->getId(), $newTransaction->getId());
            $newTransaction->setPaymentToken($payment);

            $this->transactionRepository->add($newTransaction);
            $this->serviceBookingRepository->setRebookingId($oldBooking->getId(), $newBooking->getId());
            return new RefundRequest(
                $oldBooking->getId(),
                $newBooking->getService()->getId(),
                RefundRequest::$REFUND_TYPE["REBOOK_WITH_ADDED_COST"],
                "PENDING",
                $newBooking,
            );
        }
    }
}
