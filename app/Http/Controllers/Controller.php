<?php

namespace App\Http\Controllers;

use App\Traits\ErrorTraits;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Exception;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    ## BOC : Use Error Traits to standardized error processing
    use ErrorTraits;
    ## EOC
}
