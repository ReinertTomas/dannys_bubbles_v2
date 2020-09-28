<?php
declare(strict_types=1);

namespace App\Model\Html\Priority;

use App\Model\Html\Element;

class Secondary extends Element
{

    public function __construct()
    {
        $this->text = 'Secondary';
        $this->bg = 'secondary';
        $this->icon = '';
    }

}