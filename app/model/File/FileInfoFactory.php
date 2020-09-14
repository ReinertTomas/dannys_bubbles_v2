<?php
declare(strict_types=1);

namespace App\Model\File;

class FileInfoFactory
{

    public function create(string $path, string $originalName, bool $checkPath): FileInfo
    {
        return new FileInfo($path, $originalName, $checkPath);
    }

}