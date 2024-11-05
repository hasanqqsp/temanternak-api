<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Commons\Exceptions\ClientException;
use App\Commons\Exceptions\NotFoundException;
use App\Domain\VeterinarianSchedules\Entities\NewVeterinarianSchedule;
use App\Domain\VeterinarianSchedules\Entities\VeterinarianSchedule;
use App\Domain\VeterinarianSchedules\VeterinarianScheduleRepository;
use App\Infrastructure\Repository\Models\ServiceBooking;
use App\Infrastructure\Repository\Models\User;
use App\Infrastructure\Repository\Models\VeterinarianSchedule as ModelVeterinarianSchedule;
use App\Infrastructure\Repository\Models\VeterinarianService;

class VeterinarianScheduleRepositoryEloquent implements VeterinarianScheduleRepository
{
    public function checkIfTimeIsAvailable($veterinarianId, $startTime, $endTime)
    {
        $overlappingBookings = ServiceBooking::where('veterinarian_id', $veterinarianId)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })->count();

        if ($overlappingBookings > 0) {
            throw new ClientException('The time slot is not available.');
        }

        $overlappingSchedules = ModelVeterinarianSchedule::where('veterinarian_id', $veterinarianId)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })->count();

        if ($overlappingSchedules === 0) {
            throw new ClientException('The time slot is not available.');
        }
    }

    function getAvailableStartTimes($serviceId, $bufferTime, $timeGap)
    {
        $veterinarian = VeterinarianService::find($serviceId);
        $sessionDuration = $veterinarian->duration;
        $veterinarianId = $veterinarian->veterinarian_id;

        $sessionDuration = $sessionDuration * 60;
        $minGap = $bufferTime * 60;

        $currentTime = now();
        $schedules = ModelVeterinarianSchedule::where('veterinarian_id', $veterinarianId)
            ->where('start_time', '>=', $currentTime)
            ->orderBy('start_time')
            ->get()
            ->map(function ($schedule) {
                return [
                    'start_time' => $schedule->start_time->getTimestamp(),
                    'end_time' => $schedule->end_time->getTimestamp()
                ];
            })
            ->toArray();



        $bookedSchedules = ServiceBooking::where('veterinarian_id', $veterinarianId)
            ->where('start_time', '>=', $currentTime)
            ->orderBy('start_time')
            ->get()
            ->map(function ($schedule) {
                return [
                    'start_time' => $schedule->start_time->getTimestamp(),
                    'end_time' => $schedule->end_time->getTimestamp()
                ];
            })->toArray();

        $availableSlots = [];
        foreach ($schedules as $schedule) {
            $start = $schedule['start_time'];
            $end = $schedule['end_time'];
            $currentSlotStart = $start;
            while (($currentSlotStart + $sessionDuration) - 1 <= $end) {
                $isAvailable = true;
                $currentSlotEnd = $currentSlotStart + $sessionDuration;

                foreach ($bookedSchedules as $booked) {
                    if (($currentSlotStart <= $booked['end_time'] + $minGap) && ($currentSlotEnd >= $booked['start_time'] - $minGap)) {
                        $isAvailable = false;
                        break;
                    }
                }

                if ($isAvailable) {
                    $availableSlots[] = date('Y-m-d\TH:i:s.up', $currentSlotStart);
                }

                $currentSlotStart += $bufferTime * 60;
            }
        }

        return $availableSlots;
    }

    public function getNormalizeScheduleByVeterinarianId($veterinarianId): array
    {
        $schedules = ModelVeterinarianSchedule::where('veterinarian_id', $veterinarianId)
            ->orderBy('start_time')
            ->get()
            ->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'start_time' => $schedule->start_time->setTimezone(new \DateTimeZone('UTC'))->format('Y-m-d H:i'),
                    'end_time' => $schedule->end_time->setTimezone(new \DateTimeZone('UTC'))->format('Y-m-d H:i')
                ];
            })
            ->toArray();

        $mergedSchedules = [];
        foreach ($schedules as $schedule) {
            if (empty($mergedSchedules)) {
                $mergedSchedules[] = $schedule;
            } else {
                $lastSchedule = &$mergedSchedules[count($mergedSchedules) - 1];
                if ($lastSchedule['end_time'] == $schedule['start_time']) {
                    $lastSchedule['end_time'] = $schedule['end_time'];
                } else {
                    $mergedSchedules[] = $schedule;
                }
            }
        }

        $mergedSchedules = array_map(function ($schedule) {
            $schedule['start_time'] = (new \DateTime($schedule['start_time']))->format('Y-m-d\TH:i:s.up');
            $schedule['end_time'] = (new \DateTime($schedule['end_time']))->format('Y-m-d\TH:i:s.up');
            return $schedule;
        }, $mergedSchedules);

        return $mergedSchedules;
    }

    public function add(NewVeterinarianSchedule $schedule): VeterinarianSchedule
    {

        $newSchedule = new ModelVeterinarianSchedule();
        $newSchedule->veterinarian_id = $schedule->getVeterinarianId();
        $newSchedule->start_time = $schedule->getStartTime();
        $newSchedule->end_time = $schedule->getEndTime();
        $newSchedule->save();
        return new VeterinarianSchedule(
            $newSchedule->id,
            $newSchedule->start_time->setTimezone(new \DateTimeZone('UTC')),
            $newSchedule->end_time->setTimezone(new \DateTimeZone('UTC'))
        );
    }
    public function checkIsNotOverlapping($veterinarianId, $startTime, $endTime): bool
    {
        $overlappingSchedules = ModelVeterinarianSchedule::where('veterinarian_id', $veterinarianId)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })->count();

        if ($overlappingSchedules > 0) {
            throw new ClientException('Schedule overlaps with an existing schedule.');
        }

        return true;
    }
    public function checkIfExist($scheduleId)
    {
        $schedule = ModelVeterinarianSchedule::find($scheduleId);
        if (!$schedule) {
            throw new NotFoundException('Schedule not found.');
        }
    }

    public function getByVeterinarianId($veterinarianId): array
    {
        return ModelVeterinarianSchedule::where('veterinarian_id', $veterinarianId)->get()->map(function ($schedule) {
            return (new VeterinarianSchedule(
                $schedule->id,
                $schedule->start_time,
                $schedule->end_time
            ))->toArray();
        })->toArray();
    }

    public function remove($scheduleId)
    {
        $schedule = ModelVeterinarianSchedule::find($scheduleId);
        $schedule->delete();
    }

    public function verifyOwnership($scheduleId, $credentialId)
    {
        $userRole = User::find($credentialId)->role;
        if (in_array($userRole, ['admin', 'superadmin'])) {
            return;
        }
        $schedule = ModelVeterinarianSchedule::find($scheduleId);
        if ($schedule->veterinarian_id != $credentialId) {
            throw new \Exception('Unauthorized access to schedule.');
        }
    }
}
