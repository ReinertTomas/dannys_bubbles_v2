<?php
declare(strict_types=1);

namespace App\Model\File;

use App\Model\File\Exception\FileNotFoundException;

class FileInfo extends \SplFileInfo
{

    protected string $originalName;

    public function __construct(string $path, string $originalName, bool $checkPath = true)
    {
        if ($checkPath && !is_file($path)) {
            throw new FileNotFoundException($path);
        }

        parent::__construct($path);
        $this->originalName = $originalName;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

}