<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class NotFoundException extends Exception
{
    protected $code = Response::HTTP_BAD_REQUEST;
}
