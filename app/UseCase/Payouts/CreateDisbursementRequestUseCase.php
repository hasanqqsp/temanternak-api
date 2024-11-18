<?php

namespace App\UseCase\Payouts;

use App\Domain\Payouts\DisbursementRepository;

use App\Domain\Payouts\Entities\DisbursementRequest;
use App\Domain\Users\UserRepository;

class CreateDisbursementRequestUseCase
{
    private $disbursementRepository;
    private $disbursementService;
    private $userRepository;

    public function __construct(DisbursementRepository $disbursementRepository, UserRepository $userRepository, $disbursementService)
    {
        $this->disbursementRepository = $disbursementRepository;
        $this->disbursementService = $disbursementService;
        $this->userRepository = $userRepository;
    }

    public function execute(DisbursementRequest $data)
    {
        $this->disbursementRepository->checkIdempotencyKeyExists($data->getIdempotencyKey());
        $this->disbursementRepository->checkIdempotencyKeyIsUsed($data->getIdempotencyKey());
        $this->disbursementRepository->checkBalanceIsEnough($data->getVeterinarianId(), $data->getAmount());
        $email = $this->userRepository->getById($data->getVeterinarianId())->getEmail();
        $transfer = $this->disbursementService->createDisbursement($data, $email);
        return $this->disbursementRepository->createDisbursement($data, $transfer);
    }
}
