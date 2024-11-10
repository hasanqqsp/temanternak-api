<?php

namespace App\Interfaces\Http\Controller;

use App\Commons\Exceptions\ClientException;
use App\Commons\Exceptions\UserInputException;
use App\Domain\UserFiles\UserFileRepository;
use App\Infrastructure\Repository\Storage\S3Compatible\S3FileRepository;
use Illuminate\Http\Request;
use App\Models\UserFile;
use App\UseCase\UserFiles\DeleteFileByIdUseCase;
use App\UseCase\UserFiles\DeleteFileByUserByType;
use App\UseCase\UserFiles\GetFileByIdUseCase;
use App\UseCase\UserFiles\GetFileByUserByType;
use App\UseCase\UserFiles\GetFilesByUserUseCase;
use App\UseCase\UserFiles\UploadUserFileUseCase;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class UserFilesController extends Controller
{

    protected $uploadUserFileUseCase;
    protected $getFilesByUserUseCase;
    protected $getFileByIdUseCase;
    protected $getFileByUserByTypeUseCase;
    protected $deleteFileByIdUseCase;
    protected $deleteFileByUserByTypeUseCase;
    protected $s3FileRepository;

    public function __construct(UserFileRepository $userFileRepository, S3FileRepository $s3FileRepository)
    {
        $this->uploadUserFileUseCase = new UploadUserFileUseCase($userFileRepository);
        $this->getFilesByUserUseCase = new GetFilesByUserUseCase($userFileRepository);
        $this->getFileByIdUseCase = new GetFileByIdUseCase($userFileRepository);
        $this->getFileByUserByTypeUseCase = new GetFileByUserByType($userFileRepository);
        $this->deleteFileByIdUseCase = new DeleteFileByIdUseCase($userFileRepository);
        $this->deleteFileByUserByTypeUseCase = new DeleteFileByUserByType($userFileRepository);
        $this->s3FileRepository = $s3FileRepository;
    }
    /**
     * Display a listing of the user files.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userFiles = $this->getFilesByUserUseCase->execute($request->user()->id);
        return response()->json([
            "status" => "success",
            "data" => $userFiles
        ]);
    }

    /**
     * Store a newly created user file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string',
        ]);

        $data = $this->uploadUserFileUseCase
            ->execute(
                $request->file("file"),
                $request->user()->id,
                $request->document_type
            );

        $responseArray = [
            "status" => "success",
            "message" => "File uploaded successfully. The HTML url is valid for 5 minutes",
            "data" => $data->toArray()
        ];
        return response()->json($responseArray, 201);
    }

    public function getById($fileId)
    {
        $data = $this->getFileByIdUseCase->execute($fileId);
        return response()->json([
            "status" => "success",
            "data" => $data->toArray()
        ]);
    }
    public function deleteById($fileId)
    {
        $this->deleteFileByIdUseCase->execute($fileId);
        return response()->json([
            "status" => "success",
            "message" => "File successfully deleted"
        ]);
    }

    public function delete(Request $request)
    {
        if (!$request->has("type")) {
            throw new ClientException("Can't delete all file. Specify type using query ?type=type");
        }

        $deletedCount = $this->deleteFileByUserByTypeUseCase->execute($request->user()->id, $request->query("type"));
        return response()->json([
            "status" => "success",
            "message" => "Files successfully deleted",
            "count" => $deletedCount
        ]);
    }

    public function getByPathname($pathname)
    {
        $pathname = "user_files/" . $pathname;
        $url = $this->s3FileRepository->getUrl($pathname, 60 * 24);
        return redirect($url, 301);
    }
}
