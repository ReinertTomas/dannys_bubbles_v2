<?php
declare(strict_types=1);

namespace App\Model\User\Role;

class Admin extends Role
{

    public function __construct()
    {
        $this->role = self::ADMIN;
        $this->text = 'Admin';
        $this->bg = 'warning';
        $this->icon = 'crown';
    }

}