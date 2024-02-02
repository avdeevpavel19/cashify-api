<?php

namespace App\Specifications;

interface Specifications
{
    public function toQuery($query);
}
