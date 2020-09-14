<?php
declare(strict_types=1);

namespace App\Model\User\Role;

use App\Model\User\Exception\InvalidRoleException;

class Roles
{

    /** @var array<string, Role>|Role[] */
    protected array $list = [];

    public function __construct()
    {
        $this->list[Role::ADMIN] = new Admin();
        $this->list[Role::MEMBER] = new Member();
    }

    public static function create(string $role): Role
    {
        switch ($role) {
            case Role::ADMIN:
                return new Admin();
                break;
            case Role::MEMBER:
                return new Member();
                break;
            default:
                throw new InvalidRoleException(sprintf('Unsupported role %s', $role));
        }
    }

    /**
     * @return array<string, string>
     */
    public function toItems(): array
    {
        $items = [];
        foreach ($this->list as $role) {
            $items[$role->getRole()] = $role->getText();
        }
        return $items;
    }

}