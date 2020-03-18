<?php
declare(strict_types=1);

namespace App\Modules\Front\Home;

use App\Model\Database\Entity\Offer;
use App\Model\Database\Entity\Product;
use App\Modules\Front\BaseFrontPresenter;

final class HomePresenter extends BaseFrontPresenter
{

    /** @var Product[] */
    private array $products;

    /** @var Offer[] */
    private array $offers;

    public function actionDefault(): void
    {
        $this->products = $this->em->getProductRepository()
            ->findByActivated(true);

        $this->offers = $this->em->getOfferRepository()
            ->findByActivated();
    }

    public function renderDefault(): void
    {
        $this->template->products = $this->products;
        $this->template->offers = $this->offers;
    }

}