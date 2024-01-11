<?php

namespace App\Exceptions;

class NewPasswordSameAsCurrentException extends BaseException
{
    protected $code = 422;
}
