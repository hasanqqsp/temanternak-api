<?php

namespace App\UseCase\UserFiles;

use App\Domain\UserFiles\UserFileRepository;

class UploadUserFileUseCase
{
    protected $fileRepository;

    public function __construct(UserFileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function execute($file, $userId, $documentType)
    {
        return $this->fileRepository->upload($file, $userId, $documentType);
    }
}
