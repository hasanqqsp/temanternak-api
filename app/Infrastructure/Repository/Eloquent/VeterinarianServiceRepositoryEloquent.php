<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Commons\Exceptions\ClientException;
use App\Commons\Exceptions\NotFoundException;
use App\Commons\Utils\StringUtils;
use App\Domain\Veterinarians\Entities\VeterinarianShort;
use App\Domain\VeterinarianServices\Entities\EditService;
use App\Domain\VeterinarianServices\Entities\NewService;
use App\Domain\VeterinarianServices\Entities\VetService;
use App\Domain\VeterinarianServices\Entities\VetServiceForAdmin;
use App\Domain\VeterinarianServices\VeterinarianServiceRepository;
use App\Infrastructure\Repository\Models\VeterinarianService;
use Illuminate\Auth\Access\AuthorizationException;

class VeterinarianServiceRepositoryEloquent implements VeterinarianServiceRepository
{
    public function getAllByVeterinarianId($veterinarianId)
    {
        return VeterinarianService::where('veterinarian_id', $veterinarianId)->get()->map(function ($service) {
            return $this->createVetServiceForAdmin($service)->toArray();
        });
    }

    public function getPublicByVeterinarianId($veterinarianId)
    {
        return VeterinarianService::where('veterinarian_id', $veterinarianId)
            ->whereNotNull('approved_at')
            ->whereNull('suspended_at')
            ->get()
            ->map(function ($service) {
                return $this->createVetService($service)->toArray();
            });
    }


    public function checkIfExist($id): bool
    {
        $exists = VeterinarianService::where('id', $id)->exists();
        if (!$exists) {
            throw new NotFoundException("Service not found");
        }
        return $exists;
    }
    public function deleteById($id)
    {
        $service = VeterinarianService::find($id);
        if ($service) {
            $service->delete();
        } else {
            throw new NotFoundException("Service not found");
        }
    }
    public function editWithoutApproval(EditService $data)
    {
        $existingService = VeterinarianService::find($data->getServiceId());

        $existingService->name = $data->getName();
        $existingService->description = $data->getDescription();
        $existingService->duration = $data->getDuration();
        $existingService->price = $data->getPrice();
        $existingService->save();
    }

    public function editWithApproval(EditService $data)
    {
        $existingService = VeterinarianService::find($data->getServiceId());
        $existingService->name = $data->getName();
        $existingService->description = $data->getDescription();
        $existingService->duration = $data->getDuration();
        $existingService->price = $data->getPrice();
        $existingService->approved_at = null;
        $existingService->save();
    }
    public function add(NewService $service): VetService
    {
        $newService = new VeterinarianService();
        $newService->name = $service->getName();
        $newService->description = $service->getDescription();
        $newService->veterinarian_id = $service->getVeterinarianId();
        $newService->duration = $service->getDuration();
        $newService->price =  $service->getPrice();
        $newService->save();
        return $this->createVetService($newService);
    }

    public function getById($id): VetService
    {
        $service = VeterinarianService::find($id);
        return $this->createVetService($service);
    }

    public function checkIsAccepted($id)
    {
        $service = VeterinarianService::find($id);
        if (is_null($service->approved_at)) {
            throw new ClientException("Service not approved");
        }
    }

    public function checkIsSuspended($id)
    {
        $service = VeterinarianService::find($id);
        if (is_null($service->suspended_at)) {
            throw new ClientException("Service not approved");
        }
    }

    public function checkIsApproved($id)
    {
        $service = VeterinarianService::find($id);
        if (is_null($service->approved_at)) {
            throw new ClientException("Service not approved");
        }
    }

    public function approveService($id)
    {
        $service = VeterinarianService::find($id);
        $service->approved_at = now();
        $service->save();
    }

    public function suspendService($id)
    {
        $service = VeterinarianService::find($id);
        $service->suspended_at = now();
        $service->save();
    }

    public function unsuspendService($id)
    {
        $service = VeterinarianService::find($id);
        $service->suspended_at = null;
        $service->save();
    }

    public function deleteService($id)
    {
        $service = VeterinarianService::find($id);
        if ($service) {
            $service->delete();
        } else {
            throw new ClientException("Service not found");
        }
    }

    public function getAllPublic()
    {
        return VeterinarianService::whereNotNull('approved_at')
            ->whereNull('suspended_at')
            ->get()
            ->map(function ($service) {
                return $this->createVetService($service)->toArray();
            });
    }

    public function getAll()
    {
        return VeterinarianService::withTrashed()->get()->map(function ($service) {
            return $this->createVetServiceForAdmin($service)->toArray();
        });
    }

    public function verifyOwnership($serviceId, $veterinarianId): bool
    {
        $service = VeterinarianService::find($serviceId);
        if (!$service || $service->veterinarian_id !== $veterinarianId) {
            throw new AuthorizationException("You do not have permission to modify this service");
        }
        return true;
    }

    private function createVetService($service): VetService
    {
        $veterinarian = $service->veterinarian;
        $generalIdentity = $veterinarian->veterinarianRegistration->where("status", "ACCEPTED")->first()->generalIdentity;
        return new VetService(
            $service->id,
            new VeterinarianShort(
                $veterinarian->id,
                StringUtils::nameAndTitle($generalIdentity->front_title, $veterinarian->name, $generalIdentity->back_title),
                $veterinarian->username,
                $generalIdentity->formalPhoto->file_path,
                $veterinarian->specializations,
            ),
            $service->price,
            $service->duration,
            $service->description,
            $service->name
        );
    }
    private function createVetServiceForAdmin($service): VetServiceForAdmin
    {
        $veterinarian = $service->veterinarian;
        $generalIdentity = $veterinarian->veterinarianRegistration->where("status", "ACCEPTED")->first()->generalIdentity;
        return new VetServiceForAdmin(
            $service->id,
            new VeterinarianShort(
                $veterinarian->id,
                StringUtils::nameAndTitle($generalIdentity->frontTitle, $veterinarian->name, $generalIdentity->backTitle),
                $veterinarian->username,
                $generalIdentity->formalPhoto->file_path,
                $veterinarian->specializations,
            ),
            $service->price,
            $service->duration,
            $service->description,
            $service->name,
            $service->approved_at == null ? false : true,
            $service->suspended_at == null ? false : true
        );
    }
}
