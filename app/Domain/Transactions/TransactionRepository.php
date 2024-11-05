<?php

namespace App\Domain\Transactions;

use App\Domain\Transactions\Entities\NewTransaction;

interface TransactionRepository
{
    public function add(NewTransaction $newTransaction);
    public function getByTransactionId(string $id);
    public function getAll();
    public function getByCustomerId(string $customerId);
    public function updateStatus(string $transactionId, string $status);
    public function checkIfExist(string $transactionId);
}
