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
     * @return Product[]
     */
    public function findManyByActive(): array
    {
        return $this->findBy(['active' => true], ['createdAt' => 'ASC']);
    }

    /**
     * @return Product[]
     */
    public function findManyByHighlight(): array
    {
        return $this->findBy(['active' => true, 'highlight' => true], ['createdAt' => 'ASC'], 4);
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