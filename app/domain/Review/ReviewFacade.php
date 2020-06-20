<?php
declare(strict_types=1);

namespace App\Domain\Review;

use App\Model\Database\Entity\Image;
use App\Model\Database\Entity\Review;
use App\Model\Database\EntityManager;
use App\Model\Database\Repository\ReviewRepository;
use App\Model\Exception\Runtime\UploadException;
use App\Model\File\FileTemporaryFactory;
use App\UI\Form\Review\ReviewFormType;

class ReviewFacade
{

    private EntityManager $em;

    private ReviewRepository $reviewRepository;

    private FileTemporaryFactory $fileTemporaryFactory;

    public function __construct(EntityManager $em, FileTemporaryFactory $fileTemporaryFactory)
    {
        $this->em = $em;
        $this->reviewRepository = $em->getReviewRepository();
        $this->fileTemporaryFactory = $fileTemporaryFactory;
    }

    public function get(int $id): ?Review
    {
        return $this->reviewRepository->find($id);
    }

    public function create(ReviewFormType $formType): Review
    {
        $file = $this->fileTemporaryFactory->createFromUpload($formType->image);

        $review = Review::create(
            Image::create($file, Review::NAMESPACE),
            $formType->title,
            $formType->text,
            $formType->author
        );

        $this->em->persist($review);
        $this->em->flush();

        return $review;
    }

    public function update(Review $review, ReviewFormType $formType): Review
    {
        $file = $this->fileTemporaryFactory->createFromUpload($formType->image);

        $review->changeImage($file);
        $review->changeTitle($formType->title);
        $review->changeText($formType->text);
        $review->changeAuthor($formType->author);
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