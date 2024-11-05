<?php

namespace App\UseCase\Transactions;

use App\Domain\Transactions\TransactionRepository;

class GetTransactionByIdUseCase
{
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function execute($transactionId)
    {
        return $this->transactionRepository->getByTransactionId($transactionId);
    }
}
