<?php

namespace App\UseCase\Transactions;

use App\Domain\Transactions\TransactionRepository;

class GetAllTransactionsByCustomerIdUseCase
{
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function execute(string $customerId)
    {
        return $this->transactionRepository->getByCustomerId($customerId);
    }
}
