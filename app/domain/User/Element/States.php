<?php
declare(strict_types=1);

namespace App\Domain\User\Element;

use App\Model\Database\Entity\User;
use App\Model\Element\Attributes\TElementInteger;
use App\Model\Element\Element;
use App\Model\Element\Elements;

final class States extends Elements
{

    use TElementInteger;

    protected function build(): void
    {
        $fresh = Element::create('Fresh')
            ->setBg('warning')
            ->setIcon('plus');
        $activated = Element::create('Activated')
            ->setBg('success')
            ->setIcon('check');
        $blocked = Element::create('Blocked')
            ->setBg('danger')
            ->setIcon('ban');

        $this->add(User::STATE_FRESH, $fresh);
        $this->add(User::STATE_ACTIVATED, $activated);
        $this->add(User::STATE_BLOCKED, $blocked);
    }

}