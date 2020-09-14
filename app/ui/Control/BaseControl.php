<?php
declare(strict_types=1);

namespace App\UI\Control;

use App\Model\Template\BaseTemplate;
use App\Modules\Base\BasePresenter;
use Nette\Application\UI\Control;

/**
 * @property BaseTemplate $template
 */
abstract class BaseControl extends Control
{

    protected BasePresenter $presenter;

}