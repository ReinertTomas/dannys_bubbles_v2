<?php
declare(strict_types=1);

namespace App\Model\User\State;

class Active extends State
{

    public function __construct()
    {
        $this->state = self::FRESH;
        $this->text = 'Activated';
        $this->bg = 'success';
        $this->text = 'check';
    }

}