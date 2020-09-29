<?php
declare(strict_types=1);

namespace App\Model\Offer;

use App\Model\Database\Entity\Image;
use App\Model\Database\Entity\Offer;
use App\Model\File\FileInfo;
use App\Model\File\Image\ImageFactory;

class OfferFactory
{

    protected ImageFactory $imageFactory;

    public function __construct(ImageFactory $imageFactory)
    {
        $this->imageFactory = $imageFactory;
    }

    public function create(OfferDto $dto, FileInfo $file): Offer
    {
        $image = $this->imageFactory->create($file, Image::TYPE_OFFER);

        return new Offer(
            $image,
            $dto->title,
            $dto->description,
            $dto->text
        );
    }

}