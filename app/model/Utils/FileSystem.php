<?php
declare(strict_types=1);

namespace App\Model\Utils;

use App\Model\Exception\Logic\InvalidArgumentException;
use Contributte\Utils\FileSystem as ContributteFileSystem;

final class FileSystem extends ContributteFileSystem
{

    public static function mime(string $path): string
    {
        $mime = mime_content_type($path);
        if ($mime === false) {
            throw new InvalidArgumentException(sprintf('File not exist in the path "%s:', $path));
        }
        return $mime;
    }

}