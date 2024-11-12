<?php

namespace App\UseCase\ServiceBooking;

use App\Commons\Exceptions\ClientException;
use App\Domain\ServiceBookings\Entities\NewBooking;
use App\Domain\ServiceBookings\ServiceBookingRepository;
use App\Domain\Transactions\Entities\NewTransaction;
use App\Domain\Transactions\TransactionRepository;
use App\Domain\VeterinarianSchedules\VeterinarianScheduleRepository;
use App\Domain\VeterinarianServices\VeterinarianServiceRepository;
use App\Infrastructure\Payment\MidtransPaymentGateway;
use Carbon\Carbon;

class AddServiceBookingUseCase
{
    protected $serviceBookingRepository;
    protected $transactionRepository;
    protected $veterinarianServiceRepository;
    protected $midtransPaymentGateway;
    protected $veterinarianScheduleRepository;

    public function __construct(
        ServiceBookingRepository $serviceBookingRepository,
        TransactionRepository $transactionRepository,
        VeterinarianServiceRepository $veterinarianServiceRepository,
        VeterinarianScheduleRepository $veterinarianScheduleRepository,
        MidtransPaymentGateway $midtransPaymentGateway
    ) {
        $this->serviceBookingRepository = $serviceBookingRepository;
        $this->transactionRepository = $transactionRepository;
        $this->veterinarianServiceRepository = $veterinarianServiceRepository;
        $this->veterinarianScheduleRepository = $veterinarianScheduleRepository;
        $this->midtransPaymentGateway = $midtransPaymentGateway;
    }

    public function execute(NewBooking $data)
    {
        $service = $this->veterinarianServiceRepository->getById($data->getServiceId());
        $endTime = (new Carbon($data->getStartTime()))->addMinutes($service->getDuration())->toDateTime();
        if ((new Carbon($data->getStartTime()))->diffInMinutes(now()) * -1 < 10) {
            throw new ClientException('Cannot book a service less than 10 minutes before the schedule');
        }

        $this->veterinarianScheduleRepository->checkIfTimeIsAvailable($data->getVeterinarianId(), $data->getStartTime(), $endTime);
        $booking = $this->serviceBookingRepository->add($data);
        $service = $this->veterinarianServiceRepository->getById($data->getServiceId());
        $products = [[
            'id' => 1,
            'name' => $service->getName(),
            'price' => $service->getPrice(),
            'quantity' => 1
        ]];

        $newTransaction = new NewTransaction(
            $service->getPrice(),
            $service->getPrice() * 0.15,
            $data->getBookerId(),
            $products,
        );
        $payment = $this->midtransPaymentGateway->getSnapToken(MidtransPaymentGateway::createPayload(
            $newTransaction->getId(),
            $newTransaction->getPrice(),
            $products,
            $booking->getBooker()->getName(),
            $booking->getBooker()->getEmail(),
            now()->format("Y-m-d H:i:s +Z"),
            floor(min([(new Carbon($data->getStartTime()))->subMinute()->diffInMinutes(now()) * -1, 60]))
        ));
        $this->serviceBookingRepository->setTransactionId($booking->getId(), $newTransaction->getId());
        $newTransaction->setPaymentToken($payment);

        $transaction = $this->transactionRepository->add($newTransaction);

        $booking->setTransaction($transaction);

        return $this->serviceBookingRepository->getById($booking->getId());;
    }
}
