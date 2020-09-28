<?php
declare(strict_types=1);

namespace App\Modules\Admin\Offer;

use App\Model\Database\Entity\Offer;
use App\Model\Template\BaseTemplate;

final class OfferTemplate extends BaseTemplate
{

    public ?Offer $offer;

}