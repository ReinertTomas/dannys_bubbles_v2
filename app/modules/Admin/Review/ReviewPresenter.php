<?php
declare(strict_types=1);

namespace App\Modules\Admin\Review;

use App\Domain\Review\ReviewFacade;
use App\Model\App;
use App\Model\Database\Entity\Review;
use App\Modules\Admin\BaseAdminPresenter;
use App\UI\Form\Review\ReviewFormFactory;
use App\UI\Form\Review\ReviewFormType;
use App\UI\Grid\Review\ReviewGridFactory;
use Nette\Application\UI\Form;
use Ublaboo\DataGrid\DataGrid;

final class ReviewPresenter extends BaseAdminPresenter
{

    private ?Review $review = null;

    /** @inject */
    public ReviewGridFactory $reviewGridFactory;

    /** @inject */
    public ReviewFormFactory $reviewFormFactory;

    /** @inject */
    public ReviewFacade $reviewFacade;

    public function actionReview(?int $id): void
    {
        if ($id !== null) {
            $this->review = $this->reviewFacade->get($id);
            if ($this->review === null) {
                $this->errorNotFoundEntity($id);
            }
        }
    }

    public function actionDelete(int $id): void
    {
        $review = $this->reviewFacade->get($id);
        if ($review === null) {
            $this->errorNotFoundEntity($id);
        }

        $this->reviewFacade->remove($review);
        $this->flashSuccess('messages.review.remove');

        if ($this->isAjax()) {
            $this->redrawFlashes();
            $this->getReviewGrid()->reload();
            $this->setAjaxPostGet();
        } else {
            $this->redirect(App::ADMIN_REVIEW);
        }
    }

    protected function beforeRender(): void
    {
        parent::beforeRender();

        $this->template->review = $this->review;
    }

    protected function createComponentReviewGrid(string $name): DataGrid
    {
        return $this->reviewGridFactory->create($this, $name, function ($id, $value): void {
            $id = (int)$id;
            $review = $this->reviewFacade->get($id);
            if ($review === null) {
                $this->errorNotFoundEntity($id);
            }

            $this->reviewFacade->changeActive($review, (bool)$value);

            $this->flashSuccess(
                sprintf('messages.review.%s', $review->isActive() ? 'show' : 'hide')
            );

            if ($this->isAjax()) {
                $this->redrawFlashes();
                $this->getReviewGrid()
                    ->reload();
                $this->setAjaxPostGet();
            } else {
                $this->redirect('this');
            }
        });
    }

    protected function createComponentReviewForm(): Form
    {
        return $this->reviewFormFactory->create($this->review, function (Review $review): void {
            if ($this->review === null) {
                $this->flashSuccess('messages.review.create');
            } else {
                $this->flashSuccess('messages.review.update');
            }
            $this->redirect('this', $review->getId());
        });
    }

    public function getReviewGrid(): DataGrid
    {
        /** @var DataGrid $grid */
        $grid = $this['reviewGrid'];
        return $grid;
    }

}