<?php
declare(strict_types=1);

namespace App\Domain\User\Element;

use App\Model\Database\Entity\User;
use App\Model\Element\Attributes\TElementString;
use App\Model\Element\Element;
use App\Model\Element\Elements;

final class Roles extends Elements
{

    use TElementString;

    protected function build(): void
    {
        $admin = Element::create('Admin');
        $user = Element::create('User');

        $this->add(User::ROLE_ADMIN, $admin);
        $this->add(User::ROLE_USER, $user);
    }

}