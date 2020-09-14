<?php
declare(strict_types=1);

namespace App\Model\Database\Repository;

use App\Model\Database\Entity\Image;

/**
 * @method Image|NULL find($id, ?int $lockMode = NULL, ?int $lockVersion = NULL)
 * @method Image|NULL findOneBy(array $criteria, array $orderBy = NULL)
 * @method Image[] findAll()
 * @method Image[] findBy(array $criteria, array $orderBy = NULL, ?int $limit = NULL, ?int $offset = NULL)
 * @extends AbstractRepository<Image>
 */
class ImageRepository extends AbstractRepository
{
}