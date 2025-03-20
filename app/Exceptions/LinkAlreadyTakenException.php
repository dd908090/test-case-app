<?php

namespace App\Exceptions;

use Exception;

class LinkAlreadyTakenException extends Exception
{
    protected $message = 'The link is already taken';
}
