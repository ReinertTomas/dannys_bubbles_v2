<?php
declare(strict_types=1);

namespace App\Domain\Offer;

use App\Model\Database\Entity\Image;
use App\Model\Database\Entity\Offer;
use App\Model\Database\EntityManager;
use App\Model\Exception\Runtime\UploadException;
use App\Model\File\FileTemporaryFactory;
use App\UI\Form\Offer\OfferFormType;

final class OfferFacade
{

    private EntityManager $em;

    private FileTemporaryFactory $fileTemporaryFactory;

    public function __construct(EntityManager $em, FileTemporaryFactory $fileTemporaryFactory)
    {
        $this->em = $em;
        $this->fileTemporaryFactory = $fileTemporaryFactory;
    }

    public function get(int $id): ?Offer
    {
        return $this->em->getOfferRepository()
            ->find($id);
    }

    public function create(OfferFormType $formType): Offer
    {
        if (!$formType->image->isOk()) {
            throw UploadException::create()
                ->withMessage('File upload failed.');
        }

        $file = $this->fileTemporaryFactory->createFromUpload($formType->image);

        $offer = Offer::create(
            Image::create($file, Offer::NAMESPACE),
            $formType->title,
            $formType->description,
            $formType->text
        );

        $this->em->persist($offer);
        $this->em->flush();

        return $offer;
    }

    public function update(Offer $offer, OfferFormType $formType): Offer
    {
        if ($formType->image->isOk()) {
            $offer->changeImage(
                $this->fileTemporaryFactory->createFromUpload($formType->image)
            );
        }

        $offer->changeTitle($formType->title);
        $offer->changeDescription($formType->description);
        $offer->changeText($formType->text);
        $this->em->flush();

        return $offer;
    }

    public function remove(Offer $offer): void
    {
        $this->em->remove($offer);
        $this->em->flush();
    }

    public function changeActive(Offer $offer, bool $active): Offer
    {
        if ($active) {
            $offer->enabled();
        } else {
            $offer->disabled();
        }
        $this->em->flush();

        return $offer;
    }

}