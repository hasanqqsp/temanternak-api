<?php

namespace App\Commons\Exceptions;

use Exception;

class ClientException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message = "Client error", $code = 400)
    {
        parent::__construct($message, $code);
    }

    public function getStatusCode()
    {
        return $this->code;
    }

    public function getErrorMessage()
    {
        return $this->message;
    }
}
