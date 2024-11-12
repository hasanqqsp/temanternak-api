<?php

namespace App\UseCase\Veterinarians;

use App\Domain\Users\UserRepository;
use App\Domain\Wallets\WalletLogRepository;

class GetVeterinarianWalletUseCase
{
    private $userRepository;
    private $walletLogRepository;

    public function __construct(UserRepository $userRepository, WalletLogRepository $walletLogRepository)
    {
        $this->userRepository = $userRepository;
        $this->walletLogRepository = $walletLogRepository;
    }

    public function execute(string $veterinarianId)
    {
        $balance = $this->userRepository->getWalletByUserId($veterinarianId);
        $transactions = $this->walletLogRepository->getWalletHistory($veterinarianId);
        return compact('balance', 'transactions');
    }
}
