<?php

namespace App\Exceptions;

class InternalServerException extends BaseException
{
    protected $code = 500;
}
