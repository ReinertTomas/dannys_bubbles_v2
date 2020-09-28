<?php
declare(strict_types=1);

namespace App\Model\User\State;

class Fresh extends State
{

    public function __construct()
    {
        $this->state = self::FRESH;
        $this->text = 'Fresh';
        $this->bg = 'warning';
        $this->icon = 'plus';
    }

}