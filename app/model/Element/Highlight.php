<?php
declare(strict_types=1);

namespace App\Model\Element;

final class Highlight extends Elements
{

    protected function build(): void
    {
        $this->collection[0] = Element::create('Common')
            ->setBg('secondary')
            ->setIcon('level-down-alt');
        $this->collection[1] = Element::create('Highlight')
            ->setBg('primary')
            ->setIcon('level-up-alt');
    }

    public function getCommon(): Element
    {
        return $this->collection[0];
    }

    public function getHighlight(): Element
    {
        return $this->collection[1];
    }

}