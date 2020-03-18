<?php
declare(strict_types=1);

namespace App\Model\Exception\Runtime;

use App\Model\Exception\RuntimeException;

final class InvalidStateException extends RuntimeException
{

    public static function create(string $message): InvalidStateException
    {
        return new static($message);
    }

}