<?php
declare(strict_types=1);

namespace App\Modules\Admin;

use App\Model\Database\Entity\Image;
use App\Modules\Base\SecuredPresenter;

abstract class BaseAdminPresenter extends SecuredPresenter
{

    protected function beforeRender(): void
    {
        parent::beforeRender();

        $this->template->blank_150x150 = Image::BLANK_150x150;
        $this->template->blank_200x200 = Image::BLANK_200x200;
    }

}