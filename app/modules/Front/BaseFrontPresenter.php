<?php
declare(strict_types=1);

namespace App\Modules\Front;

use App\Model\Database\Entity\Config;
use App\Modules\Base\UnsecuredPresenter;

abstract class BaseFrontPresenter extends UnsecuredPresenter
{

    protected Config $config;

    protected function startup(): void
    {
        parent::startup();
        $this->config = $this->em->getConfigRepository()->findOne();
    }

    protected function beforeRender(): void
    {
        parent::beforeRender();
        $this->template->config = $this->config;
    }


}