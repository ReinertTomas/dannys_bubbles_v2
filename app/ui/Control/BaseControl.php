<?php
declare(strict_types=1);

namespace App\UI\Control;

use App\Model\Latte\TemplateProperty;
use App\Modules\Base\BasePresenter;
use Nette\Application\UI\Control;

/**
 * @property TemplateProperty $template
 */
abstract class BaseControl extends Control
{

    protected BasePresenter $presenter;

}