<?php
declare(strict_types=1);

namespace App\Model\Review;

use App\Model\Database\Entity\Image;
use App\Model\Database\Entity\Review;
use App\Model\File\Image\ImageFactory;;

class ReviewFactory
{

    private ImageFactory $imageFactory;

    public function __construct(ImageFactory $imageFactory)
    {
        $this->imageFactory = $imageFactory;
    }

    public function create(ReviewDto $dto): Review
    {
        $image = $this->imageFactory->createFromInitial($dto->name, $dto->surname, Image::TYPE_REVIEW);
        return new Review(
            $image,
            $dto->title,
            $dto->text,
            $dto->name,
            $dto->surname
        );
    }

}