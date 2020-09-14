<?php
declare(strict_types=1);

namespace App\Model\File\Exception;

class DirectoryNotFoundException extends FileException
{

    public function __construct(string $path)
    {
        parent::__construct(
            sprintf('The directory "%s" does not exist', $path)
        );
    }

}