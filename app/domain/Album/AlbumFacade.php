<?php
declare(strict_types=1);

namespace App\Domain\Album;

use App\Model\Database\Entity\Album;
use App\Model\Database\Entity\AlbumHasImage;
use App\Model\Database\Entity\Image;
use App\Model\Database\EntityManager;
use App\Model\File\FileInfoInterface;
use App\UI\Form\Album\AlbumFormType;

class AlbumFacade
{

    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function get(int $id): ?Album
    {
        return $this->em->getAlbumRepository()
            ->find($id);
    }

    public function create(AlbumFormType $formType): Album
    {
        $album = Album::create($formType->title, $formType->text);

        $this->em->persist($album);
        $this->em->flush();

        return $album;
    }

    public function update(Album $album, AlbumFormType $formType): Album
    {
        $album->setTitle($formType->title);
        $album->setText($formType->text);
        $this->em->flush();

        return $album;
    }

    public function remove(Album $album): void
    {
        // TODO - purge images

        $this->em->remove($album);
        $this->em->flush();
    }

    public function changeActive(Album $album, bool $active): Album
    {
        if ($active) {
            $album->enabled();
        } else {
            $album->disabled();
        }
        $this->em->flush();

        return $album;
    }

    public function getAlbumHasImage(int $id): ?AlbumHasImage
    {
        return $this->em
            ->getAlbumHasImageRepository()
            ->find($id);
    }

    public function addAlbumHasImage(Album $album, FileInfoInterface $file): void
    {
        $hasImages = $album->hasImages();

        $image = Image::create($file, $album->getNamespace());
        $albumHasImage = AlbumHasImage::create($album, $image);

        $album->addImage($albumHasImage);

        $this->em->persist($image);
        $this->em->persist($albumHasImage);
        $this->em->flush();

        if (!$hasImages) {
            $this->changeCover($album, $albumHasImage);
        }
    }

    public function removeAlbumHasImage(Album $album, AlbumHasImage $albumHasImage): void
    {
        $album->removeImage($albumHasImage);

        if ($albumHasImage->isCover() && $album->hasImages()) {
            $album
                ->getImageFirst()
                ->setCover();
        }

        $this->em->remove($albumHasImage);
        $this->em->remove($albumHasImage->getImage());
        $this->em->flush();
    }

    public function changeCover(Album $album, AlbumHasImage $cover): void
    {
        foreach ($album->getImages() as $albumHasImage) {
            $albumHasImage->setUncover();
        }
        $cover->setCover();
        $this->em->flush();
    }

}