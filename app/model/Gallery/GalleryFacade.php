<?php
declare(strict_types=1);

namespace App\Model\Gallery;

use App\Model\Database\Entity\Image;
use App\Model\Database\EntityManager;
use App\Model\Database\Repository\ImageRepository;
use App\Model\File\FileInfo;
use App\Model\File\Image\ImageFactory;

class GalleryFacade
{

    private EntityManager $em;
    
    private ImageRepository $imageRepository;

    private ImageFactory $imageFactory;
    
    public function __construct(EntityManager $em, ImageFactory $imageFactory)
    {
        $this->em = $em;
        $this->imageRepository = $em->getImageRepository();
        $this->imageFactory = $imageFactory;
    }

    public function get(int $id): ?Image
    {
        return $this->imageRepository->find($id);
    }

    /**
     * @return Image[]
     */
    public function getAll(): array
    {
        return $this->imageRepository->findBy(['type' => Image::TYPE_ALBUM]);
    }

    public function create(FileInfo $file): Image
    {
        $image = $this->imageFactory->create($file, Image::TYPE_ALBUM);

        $this->em->persist($image);
        $this->em->flush();

        return $image;
    }

    public function remove(Image $image): void
    {
        $this->em->remove($image);
        $this->em->flush();
    }

}