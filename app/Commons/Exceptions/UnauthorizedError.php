<?php

namespace App\Commons\Exceptions;

use Exception;

class UnauthorizedError extends ClientException
{
    protected $message = 'Unauthorized access.';

    public function __construct($message = null, $code = 401, Exception $previous = null)
    {
        if ($message) {
            $this->message = $message;
        }
        parent::__construct($this->message, $code, $previous);
    }
}
