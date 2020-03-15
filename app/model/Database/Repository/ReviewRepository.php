<?php
declare(strict_types=1);

namespace App\Model\Database\Repository;

use App\Model\Database\Entity\Review;

/**
 * @method Review|NULL find($id, ?int $lockMode = NULL, ?int $lockVersion = NULL)
 * @method Review|NULL findOneBy(array $criteria, array $orderBy = NULL)
 * @method Review[] findAll()
 * @method Review[] findBy(array $criteria, array $orderBy = NULL, ?int $limit = NULL, ?int $offset = NULL)
 * @extends AbstractRepository<Review>
 */
class ReviewRepository extends AbstractRepository
{

}