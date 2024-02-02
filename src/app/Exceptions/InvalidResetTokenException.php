<?php

namespace App\Exceptions;

class InvalidResetTokenException extends BaseException
{
    protected $code = 422;
}
