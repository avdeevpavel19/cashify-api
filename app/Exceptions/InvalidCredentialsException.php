<?php

namespace App\Exceptions;
class InvalidCredentialsException extends BaseException
{
    protected $code = 401;
}
