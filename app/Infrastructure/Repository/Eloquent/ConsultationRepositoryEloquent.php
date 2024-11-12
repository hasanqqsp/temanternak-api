<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Commons\Exceptions\ClientException;
use App\Commons\Exceptions\NotFoundException;
use App\Domain\Consultations\ConsultationRepository;
use App\Domain\Consultations\Entities\Consultation as EntitiesConsultation;
use App\Domain\Consultations\Entities\NewConsultation;
use App\Domain\Users\Entities\User;
use App\Infrastructure\Repository\Eloquent\VeterinarianRepositoryEloquent;
use App\Infrastructure\Repository\Models\Consultation;
use App\Infrastructure\Repository\Models\ServiceBooking;
use App\Infrastructure\Repository\Models\Settlement;
use App\Infrastructure\Repository\Models\User as ModelsUser;

class ConsultationRepositoryEloquent implements ConsultationRepository
{
    public function joinConsultation($role, $bookingId)
    {
        $consultation = Consultation::where('booking_id', $bookingId)->first();
        // dd($consultation->start_time->subMinutes(5), now());
        if ($consultation->start_time->addMinutes(5) < now()) {
            throw new ClientException("You can only join the consultation 5 minutes before the start time");
        }
        if ($consultation->status == 'COMPLETED') {
            throw new ClientException("Consultation already completed");
        }
        if ($consultation->status == 'CANCELLED') {
            throw new ClientException("Consultation already cancelled");
        }
        if ($role == 'veterinarian') {
            if ($consultation->veterinarian_attend_at) {
                throw new ClientException("Veterinarian already attended");
            }
            if (!$consultation->customer_attend_at) {
                $consultation->status = 'VETERINARIAN_ATTENDED';
            } else {
                $consultation->status = 'ONPROGRESS';
            }
            $consultation->veterinarian_attend_at = now();
        } else {
            if ($consultation->customer_attend_at) {
                throw new ClientException("Customer already attended");
            }
            if (!$consultation->veterinarian_attend_at) {
                $consultation->status = 'CUSTOMER_ATTENDED';
            } else {
                $consultation->status = 'ONPROGRESS';
            }

            $consultation->customer_attend_at = now();
        }
        $consultation->save();
    }

    public function getByBookingId($bookingId): EntitiesConsultation
    {
        $consultation = Consultation::where('booking_id', $bookingId)->first();
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

    public function populate($bookingId)
    {
        $booking = ServiceBooking::find($bookingId);
        $newConsultation = new Consultation();
        $newConsultation->service_id = $booking->service_id;
        $newConsultation->veterinarian_id = $booking->veterinarian_id;
        $newConsultation->start_time = $booking->start_time;
        $newConsultation->end_time = $booking->end_time;
        $newConsultation->duration = $booking->service->duration;
        $newConsultation->customer_id = $booking->booker_id;
        $newConsultation->booking_id = $booking->id;
        $newConsultation->status = "WAITING";
        $newConsultation->save();
    }

    public function updateStatusByBookingId($bookingId, $status)
    {
        $consultation = Consultation::where("booking_id", $bookingId)->first();
        if ($consultation) {
            $consultation->status = $status;
            $consultation->save();
            return $consultation;
        }
        return null;
    }

    public function checkIfExists($bookingId)
    {
        if (!Consultation::where('booking_id', $bookingId)->exists()) {
            throw new NotFoundException("Consultation not found for booking ID: $bookingId");
        }
        return true;
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
        ServiceBooking::where('status', 'CONFIRMED')->each(function ($booking) {
            if (!Consultation::where('booking_id', $booking->id)->exists())
                $this->populate($booking->id);
        });
        return Consultation::where('veterinarian_id', $veterinarianId)->get()->map(function ($consultation) {
            $veterinarian = (new VeterinarianRepositoryEloquent())->getById($consultation->veterinarian_id);
            $this->updateStatusIfNeeded($consultation);

            return (new EntitiesConsultation(
                $consultation->id,
                $consultation->service->name,
                $veterinarian->getNameAndTitle(),
                $consultation->start_time,
                $consultation->end_time,
                $consultation->duration,
                $consultation->customer->name,
                $consultation->status,
            ))->toArray();
        })->toArray();
    }

    public function getAllByStatusAndVeterinarianId($status, $veterinarianId): array
    {
        if ('status' == 'WAITING') {
            ServiceBooking::where('status', 'CONFIRMED')->each(function ($booking) {
                if (!Consultation::where('booking_id', $booking->id)->exists())
                    $this->populate($booking->id);
            });
        }
        return Consultation::where('status', $status)
            ->where('veterinarian_id', $veterinarianId)
            ->get()->map(function ($consultation) {
                $this->updateStatusIfNeeded($consultation);

                return (new EntitiesConsultation(
                    $consultation->id,
                    $consultation->service->name,
                    $consultation->veterinarian->getNameAndTitle(),
                    $consultation->start_time,
                    $consultation->end_time,
                    $consultation->duration,
                    $consultation->customer->name,
                    $consultation->status,
                ))->toArray();
            })->toArray();
    }

    public function getAllByCustomerId($customerId): array
    {
        ServiceBooking::where('status', 'CONFIRMED')->each(function ($booking) {
            if (!Consultation::where('booking_id', $booking->id)->exists())
                $this->populate($booking->id);
        });

        return Consultation::where('customer_id', $customerId)->get()->map(function ($consultation) {
            $this->updateStatusIfNeeded($consultation);
            return (new EntitiesConsultation(
                $consultation->id,
                $consultation->service->name,
                $consultation->veterinarian,
                $consultation->start_time,
                $consultation->end_time,
                $consultation->duration,
                $consultation->customer->name,
                $consultation->status,
            ))->toArray();
        })->toArray();
    }

    public function updateStatusIfNeeded($consultation)
    {
        $booking = ServiceBooking::find($consultation->booking_id);

        // dd($consultation->settlement);
        if ($consultation->status == 'WAITING' && $consultation->veterinarian_attend_at && $consultation->customer_attend_at) {
            $consultation->status = 'ONPROGRESS';
            $consultation->save();
            return;
        }

        if ($consultation->status == 'ONPROGRESS' && $consultation->end_time < now()) {
            $consultation->status = 'COMPLETED';
            $consultation->save();
            $booking = ServiceBooking::find($consultation->booking_id);
            $booking->status = 'COMPLETED';
            $booking->save();
            $this->settleTransaction($booking, $consultation);
            return;
        }
        if (
            $consultation->status == 'COMPLETED' && (!$consultation->booking->settlement
                || !($consultation->booking->settlement->status == 'COMPLETED'))
        ) {
            $booking = ServiceBooking::find($consultation->booking_id);
            $this->settleTransaction($booking, $consultation);
            return;
        }
    }

    private function settleTransaction($booking, $consultation)
    {
        $settlement = new Settlement();
        $settlement->transaction_id = $booking->transaction_id;
        $settlement->accepted_amount = $booking->service->price -  $booking->transaction->platform_fee;
        $settlement->veterinarian_id = $consultation->veterinarian_id;
        $settlement->service_id = $consultation->service_id;
        $settlement->booking_id = $consultation->booking_id;
        $settlement->status = 'PENDING';
        $settlement->save();

        $user =  ModelsUser::find($consultation->veterinarian_id);
        $oldBalance = $user->walletBalancee;
        $user->deposit("veterinarian_wallet", $settlement->accepted_amount, $settlement->id);

        if ($user->walletBalance == ($oldBalance + $settlement->accepted_amount)) {
            $settlement->status = 'COMPLETED';
            $settlement->save();
        }
    }
}
