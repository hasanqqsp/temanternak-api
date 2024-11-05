<?php

namespace App\Interfaces\Http\Controller;

use App\Domain\ServiceBookings\ServiceBookingRepository;
use App\Domain\Transactions\TransactionRepository;
use App\UseCase\Transactions\ChangeTransactionStatusById;
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
    private $changeTransactionStatusUseCase;

    public function __construct(TransactionRepository $repository, ServiceBookingRepository $serviceBookingRepository)
    {
        $this->getAllTransactionsUseCase = new GetAllTransactionsUseCase($repository);
        $this->getAllTransactionsByCustomerIdUseCase = new GetAllTransactionsByCustomerIdUseCase($repository);
        $this->getTransactionByIdUseCase = new GetTransactionByIdUseCase($repository);
        $this->changeTransactionStatusUseCase = new ChangeTransactionStatusById($repository, $serviceBookingRepository);
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

    public function midtransHooks(Request $request)
    {
        $order_id = $request->order_id;
        $transaction = $request->transaction_status;
        $fraud = $request->fraud_status;
        $type = $request->payment_type;
        $gross_amount = $request->gross_amount;
        $status_code = $request->status_code;

        $expectedSignature = hash('sha512', $order_id . $status_code . $gross_amount . env('MIDTRANS_SERVER_KEY'));

        if ($request->signature_key != $expectedSignature) {
            return response()->json([
                "status" => "error",
                "message" => "Invalid signature"
            ], 400);
        }

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'accept') {
                    $this->changeTransactionStatusUseCase->execute($order_id, 'PAID');
                }
            }
        } else if ($transaction == 'settlement') {
            $this->changeTransactionStatusUseCase->execute($order_id, 'PAID');
        } else if ($transaction == 'pending') {
            $this->changeTransactionStatusUseCase->execute($order_id, 'PENDING');
        } else if ($transaction == 'deny') {
            $this->changeTransactionStatusUseCase->execute($order_id, 'DENIED');
        } else if ($transaction == 'expire') {
            $this->changeTransactionStatusUseCase->execute($order_id, 'EXPIRED');
        } else if ($transaction == 'cancel') {
            $this->changeTransactionStatusUseCase->execute($order_id, 'CANCELLED');
        }
        return response()->json([
            "status" => "success",
        ]);
    }
}
