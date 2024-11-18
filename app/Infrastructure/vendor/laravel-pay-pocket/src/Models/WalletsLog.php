<?php

namespace HPWebdeveloper\LaravelPayPocket\Models;

use App\Infrastructure\Repository\Models\Disbursement;
use App\Infrastructure\Repository\Models\Settlement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\MorphTo;

/**
 * HPWebdeveloper\LaravelPayPocket\Models\WalletsLog
 *
 * @property string $status
 * @property int|float $from
 * @property int|float $to
 * @property string $type
 * @property string $ip
 * @property int|float $value
 * @property string $wallet_name
 * @property string $notes
 * @property string $reference
 */
class WalletsLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'from',
        'to',
        'type',
        'ip',
        'value',
        'wallet_name',
        'notes',
        'reference',
    ];

    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }

    public function changeStatus($status)
    {
        $this->status = $status;

        return $this->save();
    }

    public function settlement()
    {
        if ($this->type == "inc")
            return $this->hasOne(Settlement::class, "id", "notes");
    }

    public function disbursement()
    {
        if ($this->type == "dec")
            return $this->hasOne(Disbursement::class, "transfer_id", "notes");
    }
}
