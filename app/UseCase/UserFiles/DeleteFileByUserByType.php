<?php

namespace App\UseCase\UserFiles;

use App\Domain\UserFiles\UserFileRepository;

class DeleteFileByUserByType
{
    protected $userFileRepository;

    public function __construct(UserFileRepository $userFileRepository)
    {
        $this->userFileRepository = $userFileRepository;
    }

    public function execute(string $userId, string $fileType)
    {
        // Fetch the file by user ID and file type
        return $this->userFileRepository->deleteAllByUserIdByType($userId, $fileType);
    }
}
