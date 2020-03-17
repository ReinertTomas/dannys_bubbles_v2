<?php
declare(strict_types=1);

namespace App\Model\Database\Repository;

use App\Model\Database\Entity\Product;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method Product|NULL find($id, ?int $lockMode = NULL, ?int $lockVersion = NULL)
 * @method Product|NULL findOneBy(array $criteria, array $orderBy = NULL)
 * @method Product[] findAll()
 * @method Product[] findBy(array $criteria, array $orderBy = NULL, ?int $limit = NULL, ?int $offset = NULL)
 * @extends AbstractRepository<Product>
 */
class ProductRepository extends AbstractRepository
{

    /**
     * @param bool $homepage
     * @return Product[]
     */
    public function findByActivated(bool $homepage = false): array
    {
        $qb = $this->createQueryBuilder('p1');
        $qb->where($qb->expr()->eq('p1.active', ':active'))
            ->setParameter('active', true);

        if ($homepage) {
            $qb->orderBy('p1.createdAt');
            $qb->setMaxResults(4);
        }

        return $qb->getQuery()
            ->getResult();
    }

}