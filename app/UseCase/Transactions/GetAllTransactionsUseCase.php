<?php

namespace App\UseCase\Transactions;

use App\Domain\Transactions\TransactionRepository;

class GetAllTransactionsUseCase
{
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function execute()
    {
        return $this->transactionRepository->getAll();
    }
}
