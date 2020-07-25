<?php
declare(strict_types=1);

namespace App\Modules\Front\Gallery;

use App\Modules\Front\BaseFrontPresenter;

final class GalleryPresenter extends BaseFrontPresenter
{

    public function renderDefault(): void
    {
        $this->template->galleries = $this->em
            ->getGalleryRepository()
            ->findAll();;
    }

}