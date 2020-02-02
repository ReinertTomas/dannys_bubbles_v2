<?php
declare(strict_types=1);

namespace App\Model\Security;

use Nette\Security\Passwords as NettePasswords;

final class Passwords extends NettePasswords
{

    public const PATTERN = '^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$';

    public function create(): Passwords
    {
        return new Passwords();
    }

}