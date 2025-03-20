<?php

namespace App\Exceptions;

use Exception;

class LinkExpiredException extends Exception
{
    protected $message = 'Link expired';
}
