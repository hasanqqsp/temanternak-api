<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Commons\Exceptions\NotFoundException;
use App\Domain\UserFiles\Entities\FileOwner;
use App\Domain\UserFiles\Entities\UserFile;
use App\Domain\UserFiles\UserFileRepository;
use App\Infrastructure\Repository\Models\User;
use App\Infrastructure\Repository\Models\UserFile as ModelsUserFile;
use App\Infrastructure\Repository\Storage\S3Compatible\S3FileRepository;

class UserFileRepositoryEloquent implements UserFileRepository
{
    public function getById($fileId): ?UserFile
    {
        $userFile = ModelsUserFile::find($fileId);
        if (!$userFile) {
            return null;
        }
        $fileOwner = User::find($userFile->user_id);
        $fileUrl = $this->fileRepository->getUrl($userFile->file_path, 60);
        return new UserFile(
            $userFile->id,
            new FileOwner(
                $fileOwner->id,
                $fileOwner->username,
                $fileOwner->name
            ),
            $fileUrl,
            $userFile->file_path,
            $userFile->created_at,
            $userFile->file_type,
        );
    }

    public function deleteById($fileId): bool
    {
        $userFile = ModelsUserFile::find($fileId);
        if (!$userFile) {
            return false;
        }
        $this->fileRepository->delete($userFile->file_path);
        return $userFile->delete();
    }

    public function getByUserIdByType($userId, $fileType): array
    {
        $userFiles = ModelsUserFile::where('user_id', $userId)->where('file_type', $fileType)->get();
        $files = [];
        foreach ($userFiles as $userFile) {
            $fileOwner = User::find($userId);
            $fileUrl = $this->fileRepository->getUrl($userFile->file_path, 5);
            $data = new UserFile(
                $userFile->id,
                new FileOwner(
                    $fileOwner->id,
                    $fileOwner->username,
                    $fileOwner->name
                ),
                $fileUrl,
                $userFile->file_path,
                $userFile->created_at,
                $userFile->file_type,
            );
            $files[] = $data->toArray();
        }
        return $files;
    }

    public function deleteAllByUserIdByType($userId, $fileType)
    {
        $userFiles = ModelsUserFile::where('user_id', $userId)->where('file_type', $fileType);
        foreach ($userFiles->get() as $userFile) {
            $this->fileRepository->delete($userFile->file_path);
            $userFile->delete();
        }
        return $userFiles->count();
    }
    protected $fileRepository;
    public function __construct()
    {
        $this->fileRepository = new S3FileRepository();
    }

    public function upload($file, $userId, $documentType): UserFile
    {
        $filePath = $this->fileRepository->upload($file, $userId, $documentType);
        $userFile = new ModelsUserFile();
        $userFile->user_id = $userId;
        $userFile->file_path = $filePath;
        $userFile->file_type = $documentType;
        $userFile->save();
        $fileOwner = User::find($userId);
        $fileUrl = $this->fileRepository->getUrl($filePath);
        $data = new UserFile(
            $userFile->id,
            new FileOwner(
                $fileOwner->id,
                $fileOwner->username,
                $fileOwner->name
            ),
            $fileUrl,
            $userFile->file_path,
            $userFile->created_at,
            $userFile->file_type,
        );
        return $data;
    }

    public function getFilesByUserId($userId): array
    {
        $userFiles = ModelsUserFile::where('user_id', $userId)->get();
        $files = [];
        foreach ($userFiles as $userFile) {
            $fileOwner = User::find($userId);
            $fileUrl = $this->fileRepository->getUrl($userFile->file_path, 5);
            $data = new UserFile(
                $userFile->id,
                new FileOwner(
                    $fileOwner->id,
                    $fileOwner->username,
                    $fileOwner->name
                ),
                $fileUrl,
                $userFile->file_path,
                $userFile->created_at,
                $userFile->file_type,
            );
            $files[] = $data->toArray();
        }
        return $files;
    }

    public function checkFileExists($fileId): bool
    {
        $userFile = ModelsUserFile::find($fileId);
        if (!$userFile) {
            throw new NotFoundException("File not found");
        }
        return true;
    }

    public function download($fileId)
    {
        // Implement the download logic here
    }

    public function delete($fileId)
    {
        // Implement the delete logic here
    }
}
