<?php
declare(strict_types=1);

namespace App\Modules\Front\Price;

use App\Model\Database\Entity\Review;
use App\Modules\Front\BaseFrontPresenter;

final class PricePresenter extends BaseFrontPresenter
{

    /** @var Review[] */
    private array $reviews;

    public function actionDefault(): void
    {
        $this->reviews = $this->em
            ->getReviewRepository()
            ->findByActive();
    }

    public function renderDefault(): void
    {
        $this->template->reviews = $this->reviews;
    }

}