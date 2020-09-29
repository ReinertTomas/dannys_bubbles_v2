<?php
declare(strict_types=1);

namespace App\Model\Offer;

use App\Model\Database\Entity\Image;
use App\Model\Database\Entity\Offer;
use App\Model\Database\EntityManager;
use App\Model\Database\Repository\OfferRepository;
use App\Model\Exception\Runtime\UploadException;
use App\Model\File\FileInfo;
use App\UI\Form\Offer\OfferFormData;

class OfferFacade
{

    private EntityManager $em;

    private OfferRepository $offerRepository;

    private OfferFactory $offerFactory;

    public function __construct(EntityManager $em, OfferFactory $offerFactory)
    {
        $this->em = $em;
        $this->offerRepository = $em->getOfferRepository();
        $this->offerFactory = $offerFactory;
    }

    public function get(int $id): ?Offer
    {
        return $this->offerRepository->find($id);
    }

    public function create(OfferDto $dto, FileInfo $file): Offer
    {
        $offer = $this->offerFactory->create($dto, $file);

        $this->em->persist($offer);
        $this->em->flush();

        return $offer;
    }

    public function update(Offer $offer, OfferDto $dto): void
    {
        $offer->changeTitle($dto->title);
        $offer->changeDescription($dto->description);
        $offer->changeText($dto->text);
        $this->em->flush();
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