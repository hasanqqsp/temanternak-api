<?php

namespace App\Commons\Exceptions;

use Exception;

class UserInputException extends ClientException
{
    protected $errors;

    public function __construct($message = "Invalid user input", $errors = [], $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
