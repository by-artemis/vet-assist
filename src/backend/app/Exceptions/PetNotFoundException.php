<?php

namespace App\Exceptions;

use Exception;

class PetNotFoundException extends Exception
{
    /** @var string */
    public $errorType = 'pet_not_found';

    /**
     * PetNotFoundException constructor.
     * @param string $message
     */
    public function __construct()
    {
        $message = __('exception.not_found', ['model' => 'Pet']);
        parent::__construct($message);
    }
}
