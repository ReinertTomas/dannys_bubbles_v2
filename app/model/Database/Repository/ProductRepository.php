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
     * @param bool $highlight
     * @return Product[]
     */
    public function findByActivated(bool $highlight = false): array
    {
        $qb = $this->createQueryBuilder('p1');
        $qb->andWhere($qb->expr()->eq('p1.active', ':active'))
            ->setParameter('active', true);

        if ($highlight) {
            $qb->andWhere($qb->expr()->eq('p1.highlight', ':highlight'))
                ->setParameter('highlight', true)
                ->setMaxResults(4);
        }

        $qb->orderBy('p1.id');
        return $qb->getQuery()
            ->getResult();
    }

    /**
     * @return Product[]
     */
    public function findByHighlighted(): array
    {
        $qb = $this->createQueryBuilder('p1');
        $qb->where($qb->expr()->eq('p1.highlight', ':highlight'))
            ->setParameter('highlight', true);

        return $qb->getQuery()
            ->getResult();
    }

}