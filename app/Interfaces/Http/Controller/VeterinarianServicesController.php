<?php

namespace App\Interfaces\Http\Controller;

use App\Domain\VeterinarianServices\Entities\EditService;
use App\Domain\VeterinarianServices\Entities\NewService;
use App\Domain\VeterinarianServices\VeterinarianServiceRepository;
use App\UseCase\Veterinarians\GetVeterinarianByIdUseCase;
use App\UseCase\VeterinarianServices\AddNewVeterinarianServiceUseCase;
use App\UseCase\VeterinarianServices\ApproveVeterinarianServiceUseCase;
use App\UseCase\VeterinarianServices\DeleteVeterinarianServiceUseCase;
use App\UseCase\VeterinarianServices\EditVeterinarianServiceUseCase;
use App\UseCase\VeterinarianServices\GetAllPublicVeterinarianServiceUseCase;
use App\UseCase\VeterinarianServices\GetAllServiceByVeterinarianIdUseCase;
use App\UseCase\VeterinarianServices\GetAllVeterinarianServiceUseCase;
use App\UseCase\VeterinarianServices\GetVeterinarianServiceByIdUseCase;
use App\UseCase\VeterinarianServices\SuspendVeterinarianServiceUseCase;
use App\UseCase\VeterinarianServices\UnsuspendVeterinarianServiceUseCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class VeterinarianServicesController extends Controller
{
    protected GetAllPublicVeterinarianServiceUseCase $getAllPublicVeterinarianServiceUseCase;
    protected GetAllVeterinarianServiceUseCase $getAllVeterinarianServiceUseCase;
    protected AddNewVeterinarianServiceUseCase $addNewVeterinarianServiceUseCase;
    protected ApproveVeterinarianServiceUseCase $approveVeterinarianServiceUseCase;
    protected SuspendVeterinarianServiceUseCase $suspendVeterinarianServiceUseCase;
    protected UnsuspendVeterinarianServiceUseCase $unsuspendVeterinarianServiceUseCase;
    protected GetVeterinarianServiceByIdUseCase $getVeterinarianServiceByIdUseCase;
    protected EditVeterinarianServiceUseCase $editVeterinarianServiceUseCase;
    protected DeleteVeterinarianServiceUseCase $deleteVeterinarianServiceUseCase;
    protected GetAllServiceByVeterinarianIdUseCase $getAllServiceByVeterinarianIdUseCase;

    public function __construct(VeterinarianServiceRepository $repository)
    {
        $this->getAllPublicVeterinarianServiceUseCase =  new GetAllPublicVeterinarianServiceUseCase($repository);
        $this->getAllVeterinarianServiceUseCase = new GetAllVeterinarianServiceUseCase($repository);
        $this->addNewVeterinarianServiceUseCase = new AddNewVeterinarianServiceUseCase($repository);
        $this->approveVeterinarianServiceUseCase = new ApproveVeterinarianServiceUseCase($repository);
        $this->suspendVeterinarianServiceUseCase = new SuspendVeterinarianServiceUseCase($repository);
        $this->unsuspendVeterinarianServiceUseCase = new UnsuspendVeterinarianServiceUseCase($repository);
        $this->getVeterinarianServiceByIdUseCase = new GetVeterinarianServiceByIdUseCase($repository);
        $this->editVeterinarianServiceUseCase = new EditVeterinarianServiceUseCase($repository);
        $this->deleteVeterinarianServiceUseCase = new DeleteVeterinarianServiceUseCase($repository);
        $this->getAllServiceByVeterinarianIdUseCase = new GetAllServiceByVeterinarianIdUseCase($repository);
    }

    public function getAll()
    {
        $data = [];
        if (request()->bearerToken() && $user = Auth::guard('sanctum')->user()) {
            if ($user->role === 'superadmin' || $user->role === 'admin') {
                $data = $this->getAllVeterinarianServiceUseCase->execute();
            } else {
                $data = $this->getAllPublicVeterinarianServiceUseCase->execute();
            }
        } else {
            $data = $this->getAllPublicVeterinarianServiceUseCase->execute();
        }
        return response()->json([
            'status' => "success",
            'data' => $data
        ]);
    }

    public function add(Request $request)
    {
        $data = $this->addNewVeterinarianServiceUseCase->execute(
            new NewService(
                $request->user()->id,
                $request->price,
                $request->duration,
                $request->description,
                $request->name
            )
        );

        return response()->json([
            'status' => "success",
            'data' => $data->toArray()
        ]);
    }

    public function approve($serviceId)
    {
        $this->approveVeterinarianServiceUseCase->execute($serviceId);
        return response()->json([
            'status' => "success",
            'message' => "Service is approved"
        ]);
    }

    public function suspend($serviceId)
    {
        $this->suspendVeterinarianServiceUseCase->execute($serviceId);
        return response()->json([
            'status' => "success",
            'message' => "Service is suspended"
        ]);
    }

    public function unsuspend($serviceId)
    {
        $this->unsuspendVeterinarianServiceUseCase->execute($serviceId);
        return response()->json([
            'status' => "success",
            'message' => "Service suspension is removed"
        ]);
    }

    public function getById($serviceId)
    {
        $data = $this->getVeterinarianServiceByIdUseCase->execute($serviceId);
        return response()->json([
            'status' => "success",
            'data' => $data->toArray()
        ]);
    }

    public function edit(Request $request, $serviceId)
    {
        $this->editVeterinarianServiceUseCase->execute(new EditService(
            $serviceId,
            $request->price,
            $request->duration,
            $request->description,
            $request->name
        ), $request->user()->id);
        return  response()->json([
            'status' => "success",
            'message' => "Service is updated successfully"
        ]);
    }

    public function delete(Request $request, $serviceId)
    {
        $oldService = $this->getVeterinarianServiceByIdUseCase->execute($serviceId);
        if ($request->user()->role === 'superadmin' || $request->user()->role === 'admin') {
            $this->deleteVeterinarianServiceUseCase->execute($serviceId, $oldService->getVeterinarian()->getId());
        } else {
            $this->deleteVeterinarianServiceUseCase->execute($serviceId, $request->user()->id);
        }
        return response()->json([
            'status' => "success",
            'message' => "Service is deleted successfully"
        ]);
    }

    public function getByVeterinarianId($veterinarianId)
    {
        $data = $this->getAllServiceByVeterinarianIdUseCase->execute($veterinarianId);
        return response()->json([
            'status' => "success",
            'data' => $data
        ]);
    }

    public function getMyServices(Request $request)
    {
        return response()->json(
            [
                'status' => "success",
                "data" => $this->getAllServiceByVeterinarianIdUseCase->execute($request->user()->id)
            ]
        );
    }
}
