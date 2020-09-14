<?php
declare(strict_types=1);

namespace App\Model\User\Role;

use App\Model\Html\Element;

abstract class Role extends Element
{

    public const ADMIN = 'admin';
    public const MEMBER = 'member';

    public const ROLES = [
        self::ADMIN,
        self::MEMBER
    ];

    protected string $role;

    public function getRole(): string
    {
        return $this->role;
    }

}