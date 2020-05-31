<?php
declare(strict_types=1);

namespace App\Model\Database\Repository;

use App\Model\Database\Entity\Product;

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
        $qb->andWhere(
            $qb->expr()->eq('p1.active', ':active')
        );
        $qb->setParameter('active', true);

        if ($highlight) {
            $qb->andWhere(
                $qb->expr()->eq('p1.highlight', ':highlight')
            );
            $qb->setParameter('highlight', true);
            $qb->setMaxResults(4);
        }

        $qb->orderBy('p1.id');
        return $qb
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Product[]
     */
    public function findByHighlighted(): array
    {
        $qb = $this->createQueryBuilder('p1');
        $qb->where(
            $qb->expr()->eq('p1.highlight', ':highlight')
        );
        $qb->setParameter('highlight', true);

        return $qb
            ->getQuery()
            ->getResult();
    }

    public function getCountHighlighted(): int
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select($qb->expr()->count('p.id'));
        $qb->where(
            $qb->expr()->eq('p.highlight', ':highlight')
        );
        $qb->setParameter('highlight', true);

        return (int)$qb
            ->getQuery()
            ->getSingleScalarResult();
    }

}