<?php
declare(strict_types=1);

namespace App\Model\Review;

use App\Model\Database\Entity\Review;
use App\Model\Database\EntityManager;
use App\Model\Database\Repository\ReviewRepository;
use App\Model\File\Image\ImageInitialFactory;

class ReviewFacade
{

    private EntityManager $em;

    private ReviewRepository $reviewRepository;

    private ReviewFactory $reviewFactory;

    private ImageInitialFactory $imageInitialFactory;

    public function __construct(EntityManager $em, ReviewFactory $reviewFactory, ImageInitialFactory $imageInitialFactory)
    {
        $this->em = $em;
        $this->reviewRepository = $em->getReviewRepository();
        $this->reviewFactory = $reviewFactory;
        $this->imageInitialFactory = $imageInitialFactory;
    }

    public function get(int $id): ?Review
    {
        return $this->reviewRepository->find($id);
    }

    public function create(ReviewDto $dto): Review
    {
        $review = $this->reviewFactory->create($dto);

        $this->em->persist($review);
        $this->em->flush();

        return $review;
    }

    public function update(Review $review, ReviewDto $dto): void
    {
        if ($review->isAuthorUpdated($dto->name, $dto->surname)) {
            $file = $this->imageInitialFactory->create($dto->name, $dto->surname);
            $review->changeImage($file);
        }

        $review->changeTitle($dto->title);
        $review->changeText($dto->text);
        $review->changeAuthor($dto->name, $dto->surname);
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