<?php

namespace App\Exceptions;

class InvalidRateApiTokenException extends BaseException
{
    protected $code = 401;
}
