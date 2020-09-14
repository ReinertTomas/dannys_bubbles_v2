<?php
declare(strict_types=1);

namespace App\Model\User\State;

class Block extends State
{

    public function __construct()
    {
        $this->state = self::FRESH;
        $this->text = 'Blocked';
        $this->bg = 'danger';
        $this->text = 'ban';
    }

}