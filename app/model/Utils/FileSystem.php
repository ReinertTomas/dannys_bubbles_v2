<?php
declare(strict_types=1);

namespace App\Model\Utils;

use Contributte\Utils\FileSystem as ContributteFileSystem;

final class FileSystem extends ContributteFileSystem
{

    public static function mime(string $path): ?string
    {
        $mime = mime_content_type($path);
        if ($mime === false) {
            return null;
        }
        return $mime;
    }

}