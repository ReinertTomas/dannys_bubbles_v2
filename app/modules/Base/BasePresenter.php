<?php
declare(strict_types=1);

namespace App\Modules\Base;

use App\Model\Database\EntityManager;
use App\Model\File\DirectoryManager;
use App\Model\Template\BaseTemplate;
use App\Modules\Base\Traits\TError;
use App\Modules\Base\Traits\TFlashMessage;
use App\Modules\Base\Traits\TModal;
use App\Modules\Base\Traits\TPayload;
use Contributte\Application\UI\Presenter\StructuredTemplates;
use Nette\Application\UI\Presenter;

/**
 * @property BaseTemplate $template
 */
abstract class BasePresenter extends Presenter
{

    use StructuredTemplates;
    use TFlashMessage;
    use TModal;
    use TPayload;
    use TError;

    /** @inject */
    public EntityManager $em;

    /** @inject */
    public DirectoryManager $dm;

    protected function beforeRender()
    {
        parent::beforeRender();

        $this->template->blank_1200x800 = '/img/blank_1200x800.png';
    }

}