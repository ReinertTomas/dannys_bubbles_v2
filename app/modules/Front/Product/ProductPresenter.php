<?php
declare(strict_types=1);

namespace App\Modules\Front\Product;

use App\Model\Database\Entity\Product;
use App\Modules\Front\BaseFrontPresenter;

final class ProductPresenter extends BaseFrontPresenter
{

    private ?Product $product = null;

    /** @var Product[] */
    private array $products;

    public function actionDefault(): void
    {
        $this->products = $this->em
            ->getProductRepository()
            ->findManyByActive();
    }

    public function actionDetail(int $id): void
    {
        $this->product = $this->em
            ->getProductRepository()
            ->find($id);

        if ($this->product === null) {
            $this->errorNotFoundEntity($id);
        }
    }

    public function renderDefault(): void
    {
        $this->template->products = $this->products;
    }

    public function renderDetail(): void
    {
        $this->template->product = $this->product;
    }

}