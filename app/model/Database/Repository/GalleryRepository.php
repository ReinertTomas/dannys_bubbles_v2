<?php
declare(strict_types=1);

namespace App\Model\Database\Repository;

use App\Model\Database\Entity\Gallery;

/**
 * @method Gallery|NULL find($id, ?int $lockMode = NULL, ?int $lockVersion = NULL)
 * @method Gallery|NULL findOneBy(array $criteria, array $orderBy = NULL)
 * @method Gallery[] findAll()
 * @method Gallery[] findBy(array $criteria, array $orderBy = NULL, ?int $limit = NULL, ?int $offset = NULL)
 * @extends AbstractRepository<Gallery>
 */
class GalleryRepository extends AbstractRepository
{

}