<?php
declare(strict_types=1);

namespace App\Model\Exception\Runtime;

use App\Model\Exception\RuntimeException;

final class FileUploadException extends RuntimeException
{

    public static function create(): FileUploadException
    {
        return new static('File upload failed.');
    }

}