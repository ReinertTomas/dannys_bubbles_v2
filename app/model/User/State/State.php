<?php
declare(strict_types=1);

namespace App\Model\User\State;

use App\Model\Html\Element;

abstract class State extends Element
{

    public const FRESH = 1;
    public const ACTIVATED = 2;
    public const BLOCKED = 3;

    public const STATES = [
        self::FRESH,
        self::ACTIVATED,
        self::BLOCKED
    ];

    protected int $state;

    public function getState(): int
    {
        return $this->state;
    }

}