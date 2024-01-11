<?php

namespace App\Exceptions;

class AvatarAlreadyUploadedException extends BaseException
{
    protected $code = 409;
}
