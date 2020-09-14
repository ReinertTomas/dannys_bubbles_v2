<?php
declare(strict_types=1);

namespace App\Model\File\Exception;

class FileUploadErrorException extends FileException
{

    public function __construct(int $error)
    {
        parent::__construct(
            sprintf('The file upload failed with error "%d".', $error)
        );
    }

}