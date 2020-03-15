<?php
declare(strict_types=1);

namespace App\Domain\Album;

use App\Domain\File\FileFacade;
use App\Model\Database\Entity\Album;
use App\Model\Database\Entity\File;
use App\Model\Database\EntityManager;

class AlbumFacade
{

    private EntityManager $em;

    private FileFacade $fileFacade;

    public function __construct(EntityManager $em, FileFacade $fileFacade)
    {
        $this->em = $em;
        $this->fileFacade = $fileFacade;
    }

    public function create(string $title, string $text): Album
    {
        $album = new Album($title, $text);

        $this->em->persist($album);
        $this->em->flush();

        return $album;
    }

    public function update(Album $album, string $title, string $text)
    {
        $album->setTitle($title);
        $album->setText($text);
        $this->em->flush();

        return $album;
    }

    public function remove(Album $album): void
    {
        // TODO - purge images

        $this->em->remove($album);
        $this->em->flush();
    }

    public function addImages(Album $album, string $json): void
    {
        $images = $this->fileFacade->createFromDropzone($json, $album->getNamespace());
        foreach ($images as $image) {
            $album->addImage($image);
        }
        $this->em->flush();
    }

    public function removeImage(Album $album, File $image): void
    {
        // Purge image
        $this->fileFacade->purge($image);
        $album->removeImage($image);
        $this->em->flush();
    }

}