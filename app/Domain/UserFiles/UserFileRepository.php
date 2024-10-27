<?php

namespace App\Domain\UserFiles;

use App\Domain\UserFiles\Entities\NewFile;
use App\Domain\UserFiles\Entities\UserFile;

interface UserFileRepository
{
    public function upload($file, $userId, $documentType): UserFile;
    public function getFilesByUserId($userId): array;
    public function download($fileId);
    public function delete($fileId);
    public function getById($fileId): ?UserFile;
    public function deleteById($fileId): bool;
    public function getByUserIdByType($userId, $documentType): array;
    public function deleteAllByUserIdByType($userId, $documentType);
    public function checkFileExists($fileId);
}
