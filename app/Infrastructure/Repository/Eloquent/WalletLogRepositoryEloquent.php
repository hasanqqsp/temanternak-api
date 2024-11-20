<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Domain\Consultations\Entities\Consultation;
use App\Domain\Consultations\Entities\ConsultationShort;
use App\Domain\Wallets\Entities\WalletLogItem;
use App\Domain\Wallets\WalletLogRepository;
use App\Infrastructure\Repository\Models\User;
use HPWebdeveloper\LaravelPayPocket\Models\WalletsLog;

class WalletLogRepositoryEloquent implements WalletLogRepository
{
    public function getWalletHistory($userId)
    {
        $wallet = User::find($userId)->wallets->first();

        $logs = WalletsLog::where('loggable_id', $wallet->id)->orderBy('updated_at', 'desc')->get()->map(
            function ($log) use ($userId) {
                if (($log->settlement() == null)) {
                    $transfer_fee = $log->disbursement->transfer_fee;
                    return (new WalletLogItem(
                        $log->id,
                        $log->from,
                        $log->to,
                        $log->value,
                        $log->value < 0 ? $transfer_fee * -1 : $transfer_fee,
                        $log->value < 0 ? $log->value + $transfer_fee : $log->value - $transfer_fee,
                        null,
                        $log->updated_at,
                    ))->toArray();
                }
                $settlement = $log->settlement;
                $booking = $settlement !== null ? $settlement->booking : null;
                $veterinarian = (new VeterinarianRepositoryEloquent())->getById($userId);
                return (new WalletLogItem(
                    $log->id,
                    $log->from,
                    $log->to,
                    $log->settlement->service->price,
                    $log->settlement->transaction->platform_fee,
                    $log->settlement->accepted_amount,
                    $booking->consultation ? new ConsultationShort(
                        $booking->consultation->id,
                        $booking->consultation->service->name,
                        $veterinarian->getNameAndTitle(),
                        $booking->consultation->start_time,
                        $booking->consultation->end_time,
                        $booking->consultation->duration,
                        $booking->consultation->customer->name,
                        $booking->consultation->status,
                        $booking->id
                    ) : null,
                    $log->updated_at,
                ))->toArray();
            }
        );
        return $logs;
    }
}
