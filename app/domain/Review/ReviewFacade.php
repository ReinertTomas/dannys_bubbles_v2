<?php
declare(strict_types=1);

namespace App\Domain\Review;

use App\Model\Database\Entity\Review;
use App\Model\Database\EntityManager;
use App\UI\Form\Review\ReviewFormType;

class ReviewFacade
{

    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function get(int $id): ?Review
    {
        return $this->em->getReviewRepository()
            ->find($id);
    }

    public function create(ReviewFormType $formType): Review
    {
        $review = Review::create($formType->title, $formType->text, $formType->author);

        $this->em->persist($review);
        $this->em->flush();

        return $review;
    }

    public function update(Review $review, ReviewFormType $formType): Review
    {
        $review->setTitle($formType->title);
        $review->setText($formType->text);
        $review->setAuthor($formType->author);
        $this->em->flush();

        return $review;
    }

    public function remove(Review $review): void
    {
        $this->em->remove($review);
        $this->em->flush();
    }

    public function changeActive(Review $review, bool $active): Review
    {
        if ($active) {
            $review->enabled();
        } else {
            $review->disabled();
        }
        $this->em->flush();

        return $review;
    }

}