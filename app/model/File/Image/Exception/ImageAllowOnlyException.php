<?php
declare(strict_types=1);

namespace App\Model\File\Exception;

use App\Model\Utils\FileSystem;

class ImageAllowOnlyException extends FileException
{

    public function __construct(string $name)
    {
        parent::__construct(
            sprintf('Only image is allow. The file extension is "%s"', FileSystem::extension($name))
        );
    }
    
}