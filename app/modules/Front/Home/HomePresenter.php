<?php
declare(strict_types=1);

namespace App\Modules\Front\Home;

use App\Model\Database\Entity\Offer;
use App\Model\Database\Entity\Product;
use App\Model\Database\Entity\Review;
use App\Modules\Front\BaseFrontPresenter;

final class HomePresenter extends BaseFrontPresenter
{

    /** @var Product[] */
    private array $products;

    /** @var Offer[] */
    private array $offers;

    /** @var Review[] */
    private array $reviews;

    public function actionDefault(): void
    {
        $this->offers = $this->em->getOfferRepository()
            ->findByActive(3);
        $this->products = $this->em->getProductRepository()
            ->findManyByHighlight();
        $this->reviews = $this->em->getReviewRepository()
            ->findByActive();
    }

    public function renderDefault(): void
    {
        $this->template->products = $this->products;
        $this->template->offers = $this->offers;
        $this->template->reviews = $this->reviews;
    }

}