<?php

namespace App\Exceptions;

use Exception;

class ClinicNotFoundException extends Exception
{
    /** @var string */
    public $errorType = 'clinic_not_found';

    /**
     * SpeciesNotFoundException constructor.
     * @param string $message
     */
    public function __construct()
    {
        $message = __('exception.not_found', ['model' => 'Clinic']);
        parent::__construct($message);
    }
}
