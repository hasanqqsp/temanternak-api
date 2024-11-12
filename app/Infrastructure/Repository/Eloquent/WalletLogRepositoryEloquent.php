<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Domain\Consultations\Entities\Consultation;
use App\Domain\Wallets\Entities\WalletLogItem;
use App\Domain\Wallets\WalletLogRepository;
use App\Infrastructure\Repository\Models\User;
use HPWebdeveloper\LaravelPayPocket\Models\WalletsLog;

class WalletLogRepositoryEloquent implements WalletLogRepository
{
    public function getWalletHistory($userId)
    {
        $wallet = User::find($userId)->wallets->first();
        $logs = WalletsLog::with("settlement")->where('loggable_id', $wallet->id)->get()->map(
            function ($log) {
                $settlement = $log->settlement;
                $booking = $settlement->booking;
                $veterinarian = (new VeterinarianRepositoryEloquent())->getById($settlement->veterinarian_id);
                return (new WalletLogItem(
                    $log->id,
                    $log->from,
                    $log->to,
                    $log->settlement->service->price,
                    $log->settlement->transaction->platform_fee,
                    $log->settlement->accepted_amount,
                    $booking->consultation ? new Consultation(
                        $booking->consultation->id,
                        $booking->consultation->service->name,
                        $veterinarian->getNameAndTitle(),
                        $booking->consultation->start_time,
                        $booking->consultation->end_time,
                        $booking->consultation->duration,
                        $booking->consultation->customer->name,
                        $booking->consultation->status,
                    ) : null,
                    $log->updated_at,
                ))->toArray();
            }
        );
        return $logs;
    }
}
