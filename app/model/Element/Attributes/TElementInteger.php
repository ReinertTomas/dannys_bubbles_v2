<?php
declare(strict_types=1);

namespace App\Model\Element\Attributes;

use App\Model\Element\Element;
use App\Model\Element\Elements;
use App\Model\Exception\Logic\InvalidArgumentException;

/**
 * @mixin Elements
 */
trait TElementInteger
{

    protected function add(int $key, Element $element): void
    {
        $this->collection[$key] = $element;
    }

    public function get(int $key): Element
    {
        if (!array_key_exists($key, $this->collection)) {
            throw InvalidArgumentException::create()
                ->withMessage('Invalid argument ' . $key);
        }
        return $this->collection[$key];
    }

}