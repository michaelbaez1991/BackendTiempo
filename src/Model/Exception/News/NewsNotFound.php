<?php

namespace App\Model\Exception\Nes;

use Exception;

class NewsNotFound extends Exception
{
    public static function throwException()
    {
        throw new self('News not found');
    }
}