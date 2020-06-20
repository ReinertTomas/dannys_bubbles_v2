<?php
declare(strict_types=1);

namespace App\Modules\Front\Offer;

use App\Model\Database\Entity\Offer;
use App\Modules\Front\BaseFrontPresenter;

final class OfferPresenter extends BaseFrontPresenter
{

    private ?Offer $offer = null;

    /** @var Offer[] */
    private array $offers;

    public function actionDefault(): void
    {
        $this->offers = $this->em
            ->getOfferRepository()
            ->findByActive();
    }

    public function actionDetail(int $id): void
    {
        $this->offer = $this->em
            ->getOfferRepository()
            ->find($id);

        if ($this->offer === null) {
            $this->errorNotFoundEntity($id);
        }
    }

    public function renderDefault(): void
    {
        $this->template->offers = $this->offers;
    }

    public function renderDetail(): void
    {
        $this->template->offer = $this->offer;
    }

}