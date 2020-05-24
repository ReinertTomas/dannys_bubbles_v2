<?php
declare(strict_types=1);

namespace App\Model\Database\Repository;

use App\Model\Database\Entity\AlbumHasImage;

/**
 * @method AlbumHasImage|NULL find($id, ?int $lockMode = NULL, ?int $lockVersion = NULL)
 * @method AlbumHasImage|NULL findOneBy(array $criteria, array $orderBy = NULL)
 * @method AlbumHasImage[] findAll()
 * @method AlbumHasImage[] findBy(array $criteria, array $orderBy = NULL, ?int $limit = NULL, ?int $offset = NULL)
 * @extends AbstractRepository<AlbumHasImage>
 */
class AlbumHasImageRepository extends AbstractRepository
{

}