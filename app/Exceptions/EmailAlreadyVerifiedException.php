<?php

namespace App\Exceptions;

class EmailAlreadyVerifiedException extends BaseException
{
    protected $code = 409;
}
