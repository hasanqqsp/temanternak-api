<?php

namespace App\Interfaces\Http\Controller;

use App\Domain\Transactions\TransactionRepository;
use App\UseCase\Transactions\GetAllTransactionsByCustomerIdUseCase;
use App\UseCase\Transactions\GetAllTransactionsUseCase;
use App\UseCase\Transactions\GetTransactionByIdUseCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TransactionsController extends Controller
{
    private $getAllTransactionsUseCase;
    private $getAllTransactionsByCustomerIdUseCase;
    private $getTransactionByIdUseCase;

    public function __construct(TransactionRepository $repository)
    {
        $this->getAllTransactionsUseCase = new GetAllTransactionsUseCase($repository);
        $this->getAllTransactionsByCustomerIdUseCase = new GetAllTransactionsByCustomerIdUseCase($repository);
        $this->getTransactionByIdUseCase = new GetTransactionByIdUseCase($repository);
    }

    public function getAll()
    {
        return response()->json([
            "status" => "success",
            "data" => $this->getAllTransactionsUseCase->execute()
        ]);
    }

    public function getAllByCustomerId($customerId)
    {
        return response()->json([
            "status" => "success",
            "data" => $this->getAllTransactionsByCustomerIdUseCase->execute($customerId)
        ]);
    }

    public function getMy(Request $request)
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->getAllTransactionsByCustomerIdUseCase->execute($request->user()->id)
        ];
        return response()->json($responseArray);
    }

    public function getById($id)
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->getTransactionByIdUseCase->execute($id)->toArray()
        ];
        return response()->json($responseArray);
    }
}
