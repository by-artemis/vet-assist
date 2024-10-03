<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\OwnerService;

class OwnerController extends Controller
{
     /** @var OwnerService */
     protected $ownerService;

     /**
      * PetController constructor.
      *
      * @param OwnerService $ownerService
      */
     public function __construct(OwnerService $ownerService)
     {
         parent::__construct();
 
         $this->ownerService = $ownerService;
     }
}
