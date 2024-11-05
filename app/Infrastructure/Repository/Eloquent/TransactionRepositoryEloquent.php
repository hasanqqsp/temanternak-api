<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Domain\Transactions\Entities\NewTransaction;
use App\Domain\Transactions\Entities\Transaction as EntitiesTransaction;
use App\Domain\Transactions\TransactionRepository;
use App\Infrastructure\Repository\Models\Transaction;

class TransactionRepositoryEloquent implements TransactionRepository
{
    public function getAll()
    {
        $transactions = Transaction::all();
        return $transactions->map(function ($transaction) {
            return $this->createTransactionEntity($transaction)->toArray();
        });
    }

    public function getByCustomerId(string $customerId)
    {
        $transactions = Transaction::where('customer_id', $customerId)->get();
        return $transactions->map(function ($transaction) {
            return $this->createTransactionEntity($transaction)->toArray();
        });
    }
    public function add(NewTransaction $newTransaction)
    {
        $transaction = new Transaction();
        $transaction->id = $newTransaction->getId();
        $transaction->price = $newTransaction->getPrice();
        $transaction->platform_fee = $newTransaction->getPlatformFee();
        $transaction->customer_id = $newTransaction->getCustomerId();
        $transaction->products = $newTransaction->getProducts();
        $transaction->payment_token = $newTransaction->getPaymentToken();
        $transaction->status = 'PENDING'; // 'PAID', 'CANCELLED', 'REFUNDED'
        $transaction->save();

        return $this->createTransactionEntity($transaction);
    }

    public function getByTransactionId(string $id)
    {
        return $this->createTransactionEntity(Transaction::where('id', $id)->first());;
    }

    private function createTransactionEntity(Transaction $transaction): EntitiesTransaction
    {
        return new EntitiesTransaction(
            $transaction->id,
            $transaction->price,
            $transaction->platform_fee,
            $transaction->customer_id,
            $transaction->products,
            $transaction->payment_token,
            $transaction->status
        );
    }
}
