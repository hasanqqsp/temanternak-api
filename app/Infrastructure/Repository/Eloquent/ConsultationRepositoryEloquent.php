use App\Models\Consultation;

<?php

use App\Commons\Utils\StringUtils;
use App\Domain\Consultations\Entities\Consultation as EntitiesConsultation;
use App\Domain\Consultations\Entities\NewConsultation;
use App\Domain\Consultations\SIPCredential;
use App\Infrastructure\Repository\Eloquent\VeterinarianRepositoryEloquent;
use App\Infrastructure\Repository\Models\Consultation;

class ConsultationRepositoryEloquent implements ConsultationRepository
{
    public function add(NewConsultation $consultation)
    {
        $newConsultation = new Consultation();
        $newConsultation->service_id = $consultation->getServiceId();
        $newConsultation->veterinarian_id = $consultation->getVeterinarianId();
        $newConsultation->start_time = $consultation->getStartTime();
        $newConsultation->end_time = $consultation->getEndTime();
        $newConsultation->duration = $consultation->getDuration();
        $newConsultation->booker_id = $consultation->getBookerId();
        $newConsultation->status = $consultation->getStatus();
        $newConsultation->save();

        return Consultation::create($consultation);
    }

    public function updateStatusById($id, $status)
    {
        $consultation = Consultation::find($id);
        if ($consultation) {
            $consultation->status = $status;
            $consultation->save();
            return $consultation;
        }
        return null;
    }

    public function getById($id): EntitiesConsultation
    {

        $consultation = Consultation::find($id);
        $veterinarian = (new VeterinarianRepositoryEloquent())->getById($consultation->veterinarian_id);
        return new EntitiesConsultation(
            $consultation->id,
            $consultation->service->name,
            $veterinarian->getNameAndTitle(),
            $consultation->start_time,
            $consultation->end_time,
            $consultation->duration,
            $consultation->customer->name,
            $consultation->status,
        );
    }

    public function getAll(): array
    {
        return [];
        // return Consultation::all();
    }

    public function getAllByStatus($status): array
    {
        return [];
        // return Consultation::where('status', $status)->get();
    }

    public function getAllByVeterinarianId($veterinarianId): array
    {
        return [];
        // return Consultation::where('veterinarian_id', $veterinarianId)->get();
    }

    public function getAllByStatusAndVeterinarianId($status, $veterinarianId): array
    {
        return [];
        // return Consultation::where('status', $status)
        //     ->where('veterinarian_id', $veterinarianId)
        //     ->get();
    }
}
