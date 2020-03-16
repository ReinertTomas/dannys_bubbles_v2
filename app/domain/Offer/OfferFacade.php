<?php
declare(strict_types=1);

namespace App\Domain\Offer;

use App\Domain\File\FileFacade;
use App\Model\Database\Entity\Offer;
use App\Model\Database\EntityManager;
use App\Model\Exception\Runtime\FileUploadException;
use App\Model\File\DirectoryManager;
use Nette\Http\FileUpload;

final class OfferFacade
{

    private EntityManager $em;

    private DirectoryManager $dm;

    private FileFacade $fileFacade;

    public function __construct(EntityManager $em, DirectoryManager $dm, FileFacade $fileFacade)
    {
        $this->em = $em;
        $this->dm = $dm;
        $this->fileFacade = $fileFacade;
    }

    public function create(string $title, string $text, FileUpload $fileUpload): Offer
    {
        if (!$fileUpload->isOk()) {
            throw FileUploadException::create();
        }

        $file = $this->fileFacade->createFromHttp($fileUpload, Offer::NAMESPACE);

        $offer = new Offer(
            $file,
            $title,
            $text
        );

        $this->em->persist($offer);
        $this->em->flush();

        return $offer;
    }

    public function update(Offer $offer, string $title, string $text, FileUpload $fileUpload): Offer
    {
        if ($fileUpload->hasFile()) {
            $this->fileFacade->update($offer->getImage(), $fileUpload, $offer->getNamespace());
        }

        $offer->setTitle($title);
        $offer->setText($text);
        $this->em->flush();

        return $offer;
    }

    public function remove(Offer $offer): void
    {
        $this->fileFacade->purge($offer->getImage());

        $this->em->remove($offer);
        $this->em->flush();
    }

}