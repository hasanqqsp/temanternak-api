<?php

namespace App\UseCase\UserFiles;

use App\Domain\UserFiles\UserFileRepository;

class GetFilesByUserUseCase
{
    private $userFileRepository;

    public function __construct(UserFileRepository $userFileRepository)
    {
        $this->userFileRepository = $userFileRepository;
    }

    public function execute(string $userId)
    {
        return $this->userFileRepository->getFilesByUserId($userId);
    }
}
