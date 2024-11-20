<?php

namespace App\Interfaces\Http\Controller;

use App\Domain\Payouts\DisbursementRepository;
use App\Domain\Payouts\Entities\DisbursementRequest;
use App\Domain\Users\UserRepository;
use App\Infrastructure\Payouts\FlipPayoutClient;
use App\UseCase\Payouts\CreateDisbursementRequestUseCase;
use App\UseCase\Payouts\GetAllDisbursementRequestUseCase;
use App\UseCase\Payouts\GetDisbursementByVeterinarianIdUseCase;
use App\UseCase\Payouts\GetDisbursementRequestByIdUseCase;
use App\UseCase\Payouts\GetIdempotencyKeyForDisbursement;
use App\UseCase\Payouts\UpdateDisbursementStatusByTransferIdUseCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PayoutsController extends Controller
{
    protected $flipPayoutClient;
    protected $createDisbursementRequestUseCase;
    protected $getIdempotencyKeyForDisbursement;
    protected $updateDisbursementStatusByTransferIdUseCase;
    protected $getDisbursementByIdUseCase;
    protected $getDisbursementByVeterinarianIdUseCase;
    protected $getAllDisbursementsUseCase;

    public function __construct(DisbursementRepository $disbursementRepository, UserRepository $userRepository)
    {
        $this->flipPayoutClient = new FlipPayoutClient();
        $this->createDisbursementRequestUseCase = new CreateDisbursementRequestUseCase($disbursementRepository, $userRepository, $this->flipPayoutClient);
        $this->getIdempotencyKeyForDisbursement = new GetIdempotencyKeyForDisbursement($disbursementRepository);
        $this->updateDisbursementStatusByTransferIdUseCase = new UpdateDisbursementStatusByTransferIdUseCase($disbursementRepository);
        $this->getDisbursementByIdUseCase = new GetDisbursementRequestByIdUseCase($disbursementRepository);
        $this->getDisbursementByVeterinarianIdUseCase = new GetDisbursementByVeterinarianIdUseCase($disbursementRepository);
        $this->getAllDisbursementsUseCase = new GetAllDisbursementRequestUseCase($disbursementRepository);
    }

    public function getBanks()
    {
        $banks = $this->flipPayoutClient->getBanks();
        return response()->json([
            "status" => "success",
            "data" => $banks
        ]);
    }

    public function getIdempotencyKey(Request $request)
    {
        $idempotencyKey = $this->getIdempotencyKeyForDisbursement->execute($request->user()->id);
        return response()->json([
            "status" => "success",
            "data" => [
                "idempotencyKey" => $idempotencyKey
            ]
        ]);
    }
    public function createDisbursementRequest(Request $request)
    {

        $data = $this->createDisbursementRequestUseCase->execute(new DisbursementRequest(
            $request->accountNumber,
            $request->bankCode,
            $request->amount,
            $request->idempotencyKey,
            $request->user()->id,
            "Balance Withdrawal"
        ));
        return [
            "status" => "success",
            "data" => $data->toArray()
        ];
    }

    public function updateStatus(Request $request)
    {

        $this->updateDisbursementStatusByTransferIdUseCase->execute(strval($request->id), $request->status, $request->receipt, $request->reason);
        return [
            "status" => "success",
        ];
    }

    public function getById(Request $request, $disbursementId)
    {
        $disbursement = $this->getDisbursementByIdUseCase->execute($disbursementId);
        return response()->json([
            "status" => "success",
            "data" => $disbursement->toArray()
        ]);
    }
    public function getMy(Request $request)
    {
        $disbursements = $this->getDisbursementByVeterinarianIdUseCase->execute($request->user()->id);
        return response()->json([
            "status" => "success",
            "data" => $disbursements->toArray()
        ]);
    }
    public function getAll()
    {
        $disbursements = $this->getAllDisbursementsUseCase->execute();
        return response()->json([
            "status" => "success",
            "data" => $disbursements->toArray()
        ]);
    }
}
