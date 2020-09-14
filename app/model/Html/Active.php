<?php
declare(strict_types=1);

namespace App\Model\Html;

final class Active extends Elements
{

    protected function build(): void
    {
        $this->collection[0] = Element::create('Disabled')
            ->setBg('danger')
            ->setIcon('ban');
        $this->collection[1] = Element::create('Enabled')
            ->setBg('success')
            ->setIcon('check');
    }

    public function getDisabled(): Element
    {
        return $this->collection[0];
    }

    public function getEnabled(): Element
    {
        return $this->collection[1];
    }

}