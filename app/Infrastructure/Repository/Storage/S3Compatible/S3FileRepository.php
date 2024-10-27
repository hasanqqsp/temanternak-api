<?php

namespace App\Infrastructure\Repository\Storage\S3Compatible;


use App\Domain\UserFiles\Entities\NewFile;
use App\Domain\UserFiles\UserFileRepository;
use App\Models\File as EloquentFile;
use Illuminate\Support\Facades\Storage;

class S3FileRepository
{
    public function upload($file, $userId, $documentType)
    {
        $timestamp = now()->getTimestamp();
        $extension = $file->getClientOriginalExtension();
        $path = "user_files/{$userId}/{$documentType}/{$timestamp}.{$extension}";
        Storage::disk('s3')->put($path, file_get_contents($file));

        return $path;
    }

    public function getUrl($path, $expiry = 5)
    {
        return Storage::disk('s3')->temporaryUrl($path, now()->addMinutes($expiry));
    }

    public function download($fileId)
    {
        // $file = $this->findById($fileId);
        // return Storage::disk('s3')->download($file->path);
    }

    public function delete($fileId)
    {
        // $file = $this->findById($fileId);
        // Storage::disk('s3')->delete($file->path);
        // EloquentFile::destroy($fileId);
    }

    public function saveMetadata(NewFile $file)
    {
        // $eloquentFile = EloquentFile::create([
        //     'user_id' => $file->userId,
        //     'path' => $file->path,
        //     'filename' => $file->filename,
        // ]);
        // $file->id = $eloquentFile->id;
    }

    public function findById($fileId)
    {
        // $record = EloquentFile::findOrFail($fileId);
        // return new DomainFile($record->id, $record->user_id, $record->path, $record->filename, $record->created_at);
    }
}
