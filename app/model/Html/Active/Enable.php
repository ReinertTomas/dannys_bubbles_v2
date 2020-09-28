<?php
declare(strict_types=1);

namespace App\Model\Html\Active;

use App\Model\Html\Element;

class Enable extends Element
{

    public function __construct()
    {
        $this->text = 'Enabled';
        $this->bg = 'success';
        $this->icon = 'check';
    }

}