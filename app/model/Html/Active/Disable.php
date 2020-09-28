<?php
declare(strict_types=1);

namespace App\Model\Html\Active;

use App\Model\Html\Element;

class Disable extends Element
{

    public function __construct()
    {
        $this->text = 'Disabled';
        $this->bg = 'danger';
        $this->icon = 'ban';
    }

}