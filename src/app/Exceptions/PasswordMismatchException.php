<?php

namespace App\Exceptions;

class PasswordMismatchException extends BaseException
{
    protected $code = 400;
}
