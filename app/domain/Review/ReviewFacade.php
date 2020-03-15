<?php
declare(strict_types=1);

namespace App\Domain\Review;

use App\Model\Database\Entity\Review;
use App\Model\Database\EntityManager;

class ReviewFacade
{

    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function create(string $title, string $text, ?string $author): Review
    {
        $review = new Review($title, $text, $author);

        $this->em->persist($review);
        $this->em->flush();

        return $review;
    }

    public function update(Review $review, string $title, string $text, ?string $author): Review
    {
        $review->setTitle($title);
        $review->setText($text);
        $review->setAuthor($author);
        $this->em->flush();

        return $review;
    }

    public function remove(Review $review): void
    {
        $this->em->remove($review);
        $this->em->flush();
    }

}