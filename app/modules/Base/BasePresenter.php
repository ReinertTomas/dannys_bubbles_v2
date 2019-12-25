<?php
declare(strict_types=1);

namespace App\Modules\Base;

use App\UI\Control\TFlashMessage;
use Contributte\Application\UI\Presenter\StructuredTemplates;
use Nette\Application\UI\Presenter;

abstract class BasePresenter extends Presenter
{
    use StructuredTemplates;
    use TFlashMessage;
}