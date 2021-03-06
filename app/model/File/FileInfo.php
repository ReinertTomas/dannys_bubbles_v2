<?php
declare(strict_types=1);

namespace App\Model\File;

use App\Model\Utils\FileSystem;
use App\Model\Utils\Strings;
use SplFileInfo;

final class FileInfo extends SplFileInfo implements FileInfoInterface
{

    public const IMAGE_MIME_TYPES = ['image/gif', 'image/png', 'image/jpeg', 'image/webp'];

    private string $name;

    public function __construct(string $file, ?string $name = null)
    {
        parent::__construct($file);
        $this->name = $name !== null ? Strings::lower($name) : parent::getFilename();
    }

    public static function create(string $file, ?string $name = null): FileInfoInterface
    {
        return new static($file, $name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFilename(): string
    {
        return parent::getFilename();
    }

    public function getPath(): string
    {
        return parent::getPath();
    }

    public function getPathname(): string
    {
        return parent::getPathname();
    }

    public function getExtension(): string
    {
        return parent::getExtension();
    }

    public function getSize(): int
    {
        return parent::getSize();
    }

    public function getMime(): string
    {
        return FileSystem::mime($this->getPathname());
    }

    public function isImage(): bool
    {
        return in_array($this->getMime(), self::IMAGE_MIME_TYPES, true);
    }

}