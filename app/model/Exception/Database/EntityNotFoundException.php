<?php
declare(strict_types=1);

namespace App\Model\Exception\Database;

use Doctrine\ORM\EntityNotFoundException as DoctrineEntityNotFoundException;

final class EntityNotFoundException extends DoctrineEntityNotFoundException
{

}