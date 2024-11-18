<?php

namespace App\Domain\Wallets;

interface WalletLogRepository
{
    public function getWalletHistory($userId);
}
