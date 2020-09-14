<?php
declare(strict_types=1);

namespace App\Model\File\Image;

use App\Model\Database\Entity\Image;
use App\Model\File\FileInfo;

class ImageFactory
{

    public function create(FileInfo $fileInfo, int $type): Image
    {
        return new Image($fileInfo, $type);
    }

}