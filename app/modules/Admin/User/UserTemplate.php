<?php
declare(strict_types=1);

namespace App\Modules\Admin\User;

use App\Model\Database\Entity\User;
use App\Model\Template\BaseTemplate;

class UserTemplate extends BaseTemplate
{

    public ?User $userSelected;

}