<?php

namespace App\UseCase\UserFiles;

use App\Domain\UserFiles\UserFileRepository;

class GetFileByUserByType
{
    protected $userFileRepository;

    public function __construct(UserFileRepository $userFileRepository)
    {
        $this->userFileRepository = $userFileRepository;
    }

    public function execute(string $userId, string $fileType)
    {
        return $this->userFileRepository->getFileByUserAndType($userId, $fileType);
    }
}
