<?php
declare(strict_types=1);

namespace App\Modules\Admin\Gallery;

use App\Model\Database\Entity\Image;
use App\Model\Template\BaseTemplate;

final class GalleryTemplate extends BaseTemplate
{

    /** @var Image[] */
    public array $images;

}