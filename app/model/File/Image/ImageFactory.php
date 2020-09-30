<?php
declare(strict_types=1);

namespace App\Model\File\Image;

use App\Model\Database\Entity\Image;
use App\Model\File\FileInfo;

class ImageFactory
{

    private ImageInitialFactory $imageInitialFactory;

    public function __construct(ImageInitialFactory $imageInitialFactory)
    {
        $this->imageInitialFactory = $imageInitialFactory;
    }

    public function create(FileInfo $fileInfo, int $type): Image
    {
        return new Image($fileInfo, $type);
    }

    public function createFromInitial(string $name, ?string $surname, int $type): Image
    {
        $file = $this->imageInitialFactory->create($name, $surname);
        return $this->create($file, $type);
    }

}