<?php
declare(strict_types=1);

namespace App\Model\Database\Repository;

use App\Model\Database\Entity\Album;

/**
 * @method Album|NULL find($id, ?int $lockMode = NULL, ?int $lockVersion = NULL)
 * @method Album|NULL findOneBy(array $criteria, array $orderBy = NULL)
 * @method Album[] findAll()
 * @method Album[] findBy(array $criteria, array $orderBy = NULL, ?int $limit = NULL, ?int $offset = NULL)
 * @extends AbstractRepository<Album>
 */
class AlbumRepository extends AbstractRepository
{

    /**
     * @return Album[]
     */
    public function findManyByActive(): array
    {
        return $this->findBy(['active' => true], ['createdAt' => 'ASC']);
    }

}