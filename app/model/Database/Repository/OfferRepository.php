<?php
declare(strict_types=1);

namespace App\Model\Database\Repository;

use App\Model\Database\Entity\Offer;
use App\Model\Database\Entity\Product;

/**
 * @method Offer|NULL find($id, ?int $lockMode = NULL, ?int $lockVersion = NULL)
 * @method Offer|NULL findOneBy(array $criteria, array $orderBy = NULL)
 * @method Offer[] findAll()
 * @method Offer[] findBy(array $criteria, array $orderBy = NULL, ?int $limit = NULL, ?int $offset = NULL)
 * @extends AbstractRepository<Offer>
 */
class OfferRepository extends AbstractRepository
{

    /**
     * @param bool $homepage
     * @return Product[]
     */
    public function findByActivated(bool $homepage = false): array
    {
        $qb = $this->createQueryBuilder('o1');
        $qb->where($qb->expr()->eq('o1.active', ':active'))
            ->setParameter('active', true);

        if ($homepage) {
            $qb->orderBy('o1.id');
            $qb->setMaxResults(4);
        }

        return $qb->getQuery()
            ->getResult();
    }
    
}