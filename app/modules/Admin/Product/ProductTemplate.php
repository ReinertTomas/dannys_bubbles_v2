<?php
declare(strict_types=1);

namespace App\Modules\Admin\Product;

use App\Model\Database\Entity\Product;
use App\Model\Template\BaseTemplate;

class ProductTemplate extends BaseTemplate
{

    public ?Product $product;

}