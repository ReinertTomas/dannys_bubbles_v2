<?php
declare(strict_types=1);

namespace App\Domain\Review;

use App\Model\Database\Entity\Image;
use App\Model\Database\Entity\Review;
use App\Model\Database\EntityManager;
use App\Model\Database\Repository\ReviewRepository;
use App\Model\File\FileInfo;

class ReviewFacade
{

    private EntityManager $em;

    private ReviewRepository $reviewRepository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->reviewRepository = $em->getReviewRepository();
    }

    public function get(int $id): ?Review
    {
        return $this->reviewRepository->find($id);
    }

    public function create(FileInfo $file, string $title, ?string $author, string $text): Review
    {
        $review = new Review(
            new Image($file, Review::NAMESPACE),
            $title,
            $text,
            $author
        );

        $this->em->persist($review);
        $this->em->flush();

        return $review;
    }

    public function update(Review $review, ?FileInfo $file, string $title, ?string $author, string $text): void
    {
        if ($file !== null) {
            $review->changeImage($file);
        }
        $review->changeTitle($title);
        $review->changeText($text);
        $review->changeAuthor($author);
        $this->em->flush();
    }

    public function remove(Review $review): void
    {
        $this->em->remove($review);
        $this->em->flush();
    }

    public function changeActive(Review $review, bool $active): void
    {
        if ($active) {
            $review->enabled();
        } else {
            $review->disabled();
        }
        $this->em->flush();
    }

}