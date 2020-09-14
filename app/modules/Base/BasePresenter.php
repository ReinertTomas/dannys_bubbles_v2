<?php
declare(strict_types=1);

namespace App\Modules\Base;

use App\Model\Database\EntityManager;
use App\Model\File\DirectoryManager;
use App\Model\Template\BaseTemplate;
use App\UI\Control\TDocument;
use App\UI\Control\TError;
use App\UI\Control\TFlashMessage;
use App\UI\Control\TModal;
use App\UI\Control\TPayload;
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
    use TDocument;

    /** @inject */
    public EntityManager $em;

    /** @inject */
    public DirectoryManager $dm;

}