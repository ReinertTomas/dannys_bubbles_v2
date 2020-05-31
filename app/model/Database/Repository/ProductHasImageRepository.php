<?php
declare(strict_types=1);

namespace App\Model\Database\Repository;

use App\Model\Database\Entity\ProductHasImage;

/**
 * @method ProductHasImage|NULL find($id, ?int $lockMode = NULL, ?int $lockVersion = NULL)
 * @method ProductHasImage|NULL findOneBy(array $criteria, array $orderBy = NULL)
 * @method ProductHasImage[] findAll()
 * @method ProductHasImage[] findBy(array $criteria, array $orderBy = NULL, ?int $limit = NULL, ?int $offset = NULL)
 * @extends AbstractRepository<ProductHasImage>
 */
class ProductHasImageRepository extends AbstractRepository
{

}