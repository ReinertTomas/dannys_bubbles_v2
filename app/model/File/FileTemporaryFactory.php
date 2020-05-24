<?php
declare(strict_types=1);

namespace App\Model\File;

use App\Model\Utils\FileSystem;
use Nette\Http\FileUpload;
use Ramsey\Uuid\Uuid;

final class FileTemporaryFactory
{

    private string $files;

    public function __construct(string $temp)
    {
        $files = $temp . '/files';
        if (realpath($files) === false) {
            FileSystem::createDir($files);
        }

        $this->files = $files;
    }

    public function createFromUpload(FileUpload $fileUpload): FileInfoInterface
    {
        $path = $this->buildPath($fileUpload->getName());
        FileSystem::rename($fileUpload->getTemporaryFile(), $path);
        return FileInfo::create($path, $fileUpload->getName());
    }

    public function createBeforeSave(string $name): FileInfoInterface
    {
        $path = $this->buildPath($name);
        return FileInfo::create($path, $name);
    }

    private function buildPath(string $name): string
    {
        return $this->files . '/' . Uuid::uuid4() . FileSystem::extension($name);
    }

}