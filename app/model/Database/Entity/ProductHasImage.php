<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\Database\Entity\Attributes\TCover;
use App\Model\Database\Entity\Attributes\TId;
use App\Model\Database\Entity\Attributes\TSort;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\ProductHasImageRepository")
 */
class ProductHasImage
{

    use TId;
    use TSort;
    use TCover;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="images")
     */
    protected Product $product;

    /**
     * @ORM\ManyToOne(targetEntity="Image")
     */
    protected Image $image;

    public function __construct(Product $product, Image $image, int $sort)
    {
        $this->product = $product;
        $this->image = $image;
        $this->sort = $sort;
        $this->cover = false;
    }

    public static function create(Product $product, Image $image, int $sort = 0): ProductHasImage
    {
        return new ProductHasImage($product, $image, $sort);
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getImage(): Image
    {
        return $this->image;
    }

}