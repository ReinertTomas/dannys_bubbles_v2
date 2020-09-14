<?php
declare(strict_types=1);

namespace App\Model\User\Role;

class Member extends Role
{

    public function __construct()
    {
        $this->role = Role::MEMBER;
        $this->text = 'Member';
        $this->bg = 'secondary';
        $this->icon = 'user';
    }

}