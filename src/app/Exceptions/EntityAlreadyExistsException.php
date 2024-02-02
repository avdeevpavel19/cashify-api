<?php

namespace App\Exceptions;

class EntityAlreadyExistsException extends BaseException
{
    protected $code = 409;
}
