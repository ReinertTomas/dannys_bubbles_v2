<?php
declare(strict_types=1);

namespace App\Model\Template;

use App\Model\Database\Entity\User;
use Nette\Bridges\ApplicationLatte\Template;

class BaseTemplate extends Template
{

    public User $userLoggedIn;

}