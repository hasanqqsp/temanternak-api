<?php

namespace App\UseCase\UserFiles;

use App\Domain\UserFiles\UserFileRepository;

class DeleteFileByIdUseCase
{
    private $userFileRepository;

    public function __construct(UserFileRepository $userFileRepository)
    {
        $this->userFileRepository = $userFileRepository;
    }

    public function execute(string $fileId): bool
    {
        $this->userFileRepository->checkFileExists($fileId);
        return $this->userFileRepository->deleteById($fileId);
    }
}
