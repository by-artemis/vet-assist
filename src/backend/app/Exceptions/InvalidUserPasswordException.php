<?php

namespace App\Exceptions;

use Exception;

class InvalidUserPasswordException extends Exception
{
    /** @var string */
    public $errorType = 'invalid_password';

    /**
     * InvalidUserPasswordException constructor.
     * @param string $message
     */
    public function __construct()
    {
        $message = __('exception.invalid_user_password');
        parent::__construct($message);
    }
}
