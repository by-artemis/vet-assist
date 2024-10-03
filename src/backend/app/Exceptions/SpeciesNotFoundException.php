<?php

namespace App\Exceptions;

use Exception;

class SpeciesNotFoundException extends Exception
{
    /** @var string */
    public $errorType = 'species_not_found';

    /**
     * SpeciesNotFoundException constructor.
     * @param string $message
     */
    public function __construct()
    {
        $message = __('exception.not_found', ['model' => 'Species']);
        parent::__construct($message);
    }
}
