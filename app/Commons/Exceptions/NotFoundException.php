<?php

namespace App\Commons\Exceptions;

use Exception;
use Illuminate\Support\Facades\Exceptions;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class NotFoundException extends ClientException
{
    public function __construct($message = "Resource not found", $code = 404, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
