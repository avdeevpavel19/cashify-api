<?php

namespace App\Exceptions;

class EntityNotFoundException extends BaseException
{
    protected $code = 404;
}
