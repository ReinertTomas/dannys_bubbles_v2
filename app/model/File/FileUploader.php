<?php
declare(strict_types=1);

namespace App\Model\File;

use App\Model\File\Exception\DirectoryNotFoundException;
use App\Model\File\Exception\FileUploadErrorException;
use App\Model\Utils\FileSystem;
use Nette\Http\FileUpload;
use Ramsey\Uuid\Uuid;

class FileUploader
{

    private string $directory;

    public function __construct(string $directory)
    {
        FileSystem::createDir($directory, 0755);

        $directory = realpath($directory);
        if (!is_dir($directory)) {
            throw new DirectoryNotFoundException($directory);
        }

        $this->directory = $directory;
    }

    public function upload(FileUpload $file): FileInfo
    {
        if (!$file->isOk()) {
            throw new FileUploadErrorException($file->getError());
        }

        $filename = $this->directory . '/' . Uuid::uuid4() . FileSystem::extension($file->getName());
        $file->move($filename);

        return new FileInfo($file->getTemporaryFile(), $file->getName());
    }

}