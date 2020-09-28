<?php
declare(strict_types=1);

namespace App\Model\Html\Priority;

use App\Model\Html\Element;

class Primary extends Element
{

    public function __construct()
    {
        $this->text = 'Primary';
        $this->bg = 'primary';
        $this->icon = '';
    }

}