<?php

namespace App\UseCase\UserFiles;

use App\Domain\UserFiles\UserFileRepository;

class GetFileByIdUseCase
{
    private $userFileRepository;

    public function __construct(UserFileRepository $userFileRepository)
    {
        $this->userFileRepository = $userFileRepository;
    }

    public function execute(string $fileId)
    {
        $this->userFileRepository->checkFileExists($fileId);

        return $this->userFileRepository->getById($fileId);
    }
}
