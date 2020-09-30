<?php
declare(strict_types=1);

namespace App\Modules\Admin\Review;

use App\Model\Database\Entity\Review;
use App\Model\Template\BaseTemplate;

final class ReviewTemplate extends BaseTemplate
{

    public ?Review $review;

}