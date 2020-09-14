<?php
declare(strict_types=1);

namespace App\Model\User\State;

use App\Model\User\Exception\InvalidStateException;

class States
{

    /** @var array<int, State>|State[] */
    protected array $list = [];

    public function __construct()
    {
        $this->list[State::FRESH] = new Fresh();
        $this->list[State::ACTIVATED] = new Active();
        $this->list[State::BLOCKED] = new Block();
    }

    public static function create(int $state): State
    {
        switch ($state) {
            case State::FRESH:
                return new Fresh();
                break;
            case State::ACTIVATED:
                return new Active();
                break;
            case State::BLOCKED:
                return new Block();
                break;
            default:
                throw new InvalidStateException(sprintf('Unsupported state %d', $state));
        }
    }

    public function get(int $state): State
    {
        if (!array_key_exists($state, $this->list)) {
            throw new InvalidStateException(sprintf('Unsupported role %d', $state));
        }
        return $this->list[$state];
    }

    /**
     * @return array<int, string>
     */
    public function toItems(): array
    {
        $items = [];
        foreach ($this->list as $state) {
            $items[$state->getState()] = $state->getText();
        }
        return $items;
    }

}